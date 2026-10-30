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
        $query = Product::with('category');

        if ($request->filled('search')) {
            $searchTerm = $request->search;
            $query->where(function($q) use ($searchTerm) {
                $q->where('name', 'like', '%' . $searchTerm . '%')
                  ->orWhere('sku', 'like', '%' . $searchTerm . '%');
            });
        }

        if ($request->filled('filter')) {
            if ($request->filter == 'discounted') {
                $query->whereNotNull('discount_price')->where('discount_price', '>', 0);
            } elseif ($request->filter == 'bestseller') {
                $query->where('is_best_seller', true); 
            }
        }

        $products = $query->latest()->paginate(12)->withQueryString();

        return view('admin.products.index', compact('products'));
    }

    public function create()
    {
        $categories = Category::all();
        return view('admin.products.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:36',
            'sku' => 'nullable|string|max:50|unique:products,sku',
            'category_id' => 'nullable|exists:categories,id',
            'description' => 'nullable|string|max:505',
            'price' => 'required|numeric|min:0',
            'discount_price' => 'nullable|numeric|min:0|lt:price',
            'stock' => 'required|integer|min:0',
            'trendyol_url' => 'nullable|url',
            'hepsiburada_url' => 'nullable|url',
            'idefix_url' => 'nullable|url',
            'amazon_url' => 'nullable|url',
            'pazarama_url' => 'nullable|url',
            'is_best_seller' => 'nullable|boolean',
        ]);

        // SKU boş bırakıldıysa otomatik üret
        if (empty($validated['sku'])) {
            $validated['sku'] = 'SKU-' . strtoupper(Str::random(8));
        } else {
            $validated['sku'] = strtoupper($validated['sku']);
        }

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
                    if (in_array($ext, ['jpeg', 'png', 'jpg', 'webp']) && $image->getSize() <= (2048 * 1024)) {
                        $imageName = time() . '_' . uniqid() . '.' . $ext;
                        $image->move($destinationPath, $imageName);
                        $imagePaths[] = 'img/products/' . $imageName;
                    }
                }
            }
        }

        $validated['images'] = $imagePaths;
        $validated['slug'] = Str::slug($request->name) . '-' . uniqid();

        Product::create($validated);

        return redirect()->route('admin.products.index')->with('success', 'Ürün başarıyla eklendi.');
    }

    public function edit(Product $product)
    {
        $categories = Category::all();
        return view('admin.products.edit', compact('product', 'categories'));
    }

    public function update(Request $request, Product $product)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:36',
            'sku' => 'nullable|string|max:50|unique:products,sku,' . $product->id,
            'category_id' => 'nullable|exists:categories,id',
            'description' => 'nullable|string|max:505',
            'price' => 'required|numeric|min:0',
            'discount_price' => 'nullable|numeric|min:0|lt:price',
            'stock' => 'required|integer|min:0',
            'trendyol_url' => 'nullable|url',
            'hepsiburada_url' => 'nullable|url',
            'idefix_url' => 'nullable|url',
            'amazon_url' => 'nullable|url',
            'pazarama_url' => 'nullable|url',
            'is_best_seller' => 'nullable|boolean',
        ]);

        if (!empty($validated['sku'])) {
            $validated['sku'] = strtoupper($validated['sku']);
        }

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
                    if (in_array($ext, ['jpeg', 'png', 'jpg', 'webp']) && $image->getSize() <= (2048 * 1024)) {
                        $imageName = time() . '_' . uniqid() . '.' . $ext;
                        $image->move($destinationPath, $imageName);
                        $imagePaths[] = 'img/products/' . $imageName;
                    }
                }
            }
        }

        $validated['images'] = $imagePaths;
        $validated['slug'] = Str::slug($request->name) . '-' . $product->id;

        $product->update($validated);

        return redirect()->route('admin.products.index')->with('success', 'Ürün ve görseller başarıyla güncellendi.');
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

        return redirect()->route('admin.products.index')->with('success', 'Ürün başarıyla silindi.');
    }

public function exportExcel()
{
    $fileName = 'alveral-urun-listesi-' . date('d-m-Y') . '.xls';
    
    $headers = [
        "Content-type"        => "application/vnd.ms-excel; charset=UTF-8",
        "Content-Disposition" => "attachment; filename=$fileName",
        "Pragma"              => "no-cache",
        "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
        "Expires"             => "0"
    ];

    $products = Product::with('category')->get();

    $trToEn = function ($text) {
        if (is_null($text)) return '-';
        $search  = ['ç', 'Ç', 'ğ', 'Ğ', 'ı', 'İ', 'ö', 'Ö', 'ş', 'Ş', 'ü', 'Ü'];
        $replace = ['c', 'C', 'g', 'G', 'i', 'I', 'o', 'O', 's', 'S', 'u', 'U'];
        return str_replace($search, $replace, (string)$text);
    };

    $callback = function() use ($products, $trToEn) {
        echo "\xEF\xBB\xBF";
        
        echo '<html xmlns:o="urn:schemas-microsoft-com:office:office" xmlns:x="urn:schemas-microsoft-com:office:excel" xmlns="http://www.w3.org/TR/REC-html40">';
        echo '<head>';
        echo '<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />';
        echo '<style>';
        echo '  table { border-collapse: collapse; font-family: "Segoe UI", Tahoma, Arial, sans-serif; font-size: 13px; width: 100%; }';
        echo '  th { background-color: #1b5e20; color: #ffffff; font-weight: bold; text-align: center; border: 1px solid #0d3b10; padding: 12px; white-space: nowrap; }';
        echo '  td { border: 1px solid #dcdcdc; padding: 10px; vertical-align: middle; white-space: nowrap; }';
        echo '  .row-even { background-color: #f9f9f9; }';
        echo '  .num-cell { text-align: right; font-weight: 500; }';
        echo '  .center-cell { text-align: center; }';
        echo '</style>';
        echo '</head>';
        echo '<body>';
        echo '<table>';
        
        echo '<thead>';
        echo '<tr>';
        echo '<th style="width: 180px;">Stok Kodu (SKU)</th>';
        echo '<th style="width: 120px;">Stok Adedi</th>';
        echo '<th style="width: 350px;">Stok Adi (Urun Adi)</th>';
        echo '<th style="width: 400px;">Aciklama</th>';
        echo '<th style="width: 220px;">Kategori</th>';
        echo '<th style="width: 150px;">Fiyat (TL)</th>';
        echo '<th style="width: 180px;">Indirimli Fiyat (TL)</th>';
        echo '<th style="width: 130px;">Urun Durumu</th>';
        echo '<th style="width: 300px;">Trendyol Linki</th>';
        echo '<th style="width: 300px;">Hepsiburada Linki</th>';
        echo '<th style="width: 300px;">Idefix Linki</th>';
        echo '<th style="width: 300px;">Amazon Linki</th>';
        echo '<th style="width: 300px;">Pazarama Linki</th>';
        echo '<th style="width: 180px;">Olusturulma Tarihi</th>';
        echo '</tr>';
        echo '</thead>';
        echo '<tbody>';

        $i = 0;
        foreach ($products as $product) {
            $rowClass = ($i % 2 === 0) ? '' : 'class="row-even"';
            
            echo "<tr $rowClass>";
            echo '<td class="center-cell" style="font-weight: bold;">' . htmlspecialchars($trToEn($product->sku)) . '</td>';
            echo '<td class="center-cell" style="font-weight: bold; color: #2e7d32;">' . $product->stock . '</td>';
            echo '<td>' . htmlspecialchars($trToEn($product->name)) . '</td>';
            echo '<td>' . htmlspecialchars($trToEn(strip_tags($product->description ?? '-'))) . '</td>';
            echo '<td>' . htmlspecialchars($trToEn($product->category->name ?? 'Kategorisiz')) . '</td>';
            echo '<td class="num-cell">' . number_format($product->price, 2, ',', '.') . ' TL</td>';
            echo '<td class="num-cell">' . ($product->discount_price ? number_format($product->discount_price, 2, ',', '.') . ' TL' : '-') . '</td>';
            echo '<td class="center-cell">' . (($product->is_active ?? true) ? 'Aktif' : 'Pasif') . '</td>';
            echo '<td>' . htmlspecialchars($trToEn($product->trendyol_url ?? '-')) . '</td>';
            echo '<td>' . htmlspecialchars($trToEn($product->hepsiburada_url ?? '-')) . '</td>';
            echo '<td>' . htmlspecialchars($trToEn($product->idefix_url ?? '-')) . '</td>';
            echo '<td>' . htmlspecialchars($trToEn($product->amazon_url ?? '-')) . '</td>';
            echo '<td>' . htmlspecialchars($trToEn($product->pazarama_url ?? '-')) . '</td>';
            echo '<td class="center-cell">' . ($product->created_at ? $product->created_at->format('d.m.Y H:i') : '-') . '</td>';
            echo '</tr>';
            
            $i++;
        }

        echo '</tbody>';
        echo '</table>';
        echo '</body>';
        echo '</html>';
    };

    return response()->stream($callback, 200, $headers);
}
}