<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    
public function index(Request $request)
{
    $search = $request->input('search');

    $products = Product::with('category')
        ->when($search, function ($query, $search) {
            return $query->where('name', 'like', "%{$search}%")
                         ->orWhere('sku', 'like', "%{$search}%");
        })
        ->latest()
        ->paginate(10)
        ->withQueryString();

    return view('admin.products.index', compact('products', 'search'));
}

    public function create()
    {
        $categories = Category::all();
        return view('admin.products.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'category_id' => 'nullable|exists:categories,id',
            'description' => 'nullable|string',
            'price' => 'required|numeric',
            'stock' => 'required|integer',
            'affiliate_url' => 'required|url',
            'is_best_seller' => 'nullable|boolean',
        ]);

        if ($request->has('is_best_seller')) {
            $validated['is_best_seller'] = true;
            
            if (Product::where('is_best_seller', true)->count() >= 7) {
                $oldest = Product::where('is_best_seller', true)->oldest()->first();
                if ($oldest) {
                    $oldest->update(['is_best_seller' => false]);
                }
            }
        } else {
            $validated['is_best_seller'] = false;
        }

        $imagePaths = [];

        if ($request->hasFile('images')) {
            $destinationPath = public_path('img/products');
            if (!file_exists($destinationPath)) {
                mkdir($destinationPath, 0777, true);
            }

            foreach ($request->file('images') as $image) {
                if ($image && $image->isValid()) {
                    $ext = strtolower($image->getClientOriginalExtension());
                    if (in_array($ext, ['jpeg', 'png', 'jpg', 'webp']) && $image->getSize() <= 2048 * 1024) {
                        $imageName = time() . '_' . uniqid() . '.' . $ext;
                        $image->move($destinationPath, $imageName);
                        $imagePaths[] = 'img/products/' . $imageName;
                    }
                }
            }
        }

        $validated['images'] = $imagePaths;
        $validated['slug'] = Str::slug($request->name);

        Product::create($validated);

        return redirect()->route('products.index')->with('success', 'Ürün başarıyla eklendi.');
    }

    public function edit(Product $product)
    {
        $categories = Category::all();
        return view('admin.products.edit', compact('product', 'categories'));
    }

    public function update(Request $request, Product $product)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'category_id' => 'nullable|exists:categories,id',
            'description' => 'nullable|string',
            'price' => 'required|numeric',
            'stock' => 'required|integer',
            'affiliate_url' => 'required|url',
            'is_best_seller' => 'nullable|boolean',
        ]);

        if ($request->has('is_best_seller')) {
            $validated['is_best_seller'] = true;
            
            if (Product::where('is_best_seller', true)->where('id', '!=', $product->id)->count() >= 7) {
                $oldest = Product::where('is_best_seller', true)->where('id', '!=', $product->id)->oldest()->first();
                if ($oldest) {
                    $oldest->update(['is_best_seller' => false]);
                }
            }
        } else {
            $validated['is_best_seller'] = false;
        }

        $imagePaths = $product->images ?? [];

        if ($request->has('delete_images')) {
            foreach ($request->delete_images as $oldImg) {
                $filePath = public_path($oldImg);
                if (file_exists($filePath)) {
                    @unlink($filePath);
                }
                $imagePaths = array_values(array_diff($imagePaths, [$oldImg]));
            }
        }

        if ($request->hasFile('images')) {
            $destinationPath = public_path('img/products');
            if (!file_exists($destinationPath)) {
                mkdir($destinationPath, 0777, true);
            }

            foreach ($request->file('images') as $image) {
                if ($image && $image->isValid()) {
                    $ext = strtolower($image->getClientOriginalExtension());
                    if (in_array($ext, ['jpeg', 'png', 'jpg', 'webp']) && $image->getSize() <= 2048 * 1024) {
                        $imageName = time() . '_' . uniqid() . '.' . $ext;
                        $image->move($destinationPath, $imageName);
                        $imagePaths[] = 'img/products/' . $imageName;
                    }
                }
            }
        }

        $validated['images'] = $imagePaths;
        $validated['slug'] = Str::slug($request->name);

        $product->update($validated);

        return redirect()->route('products.index')->with('success', 'Ürün ve görseller başarıyla güncellendi.');
    }

    public function destroy(Product $product)
    {
        if ($product->images) {
            foreach ($product->images as $img) {
                $filePath = public_path($img);
                if (file_exists($filePath)) {
                    @unlink($filePath);
                }
            }
        }

        $product->delete();

        return redirect()->route('products.index')->with('success', 'Ürün başarıyla silindi.');
    }
}