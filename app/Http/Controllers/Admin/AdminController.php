<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ContactMessage;
use App\Models\Product;
use App\Models\Category;
use App\Models\Visitor;
use App\Models\MarketplaceProduct;

class AdminController extends Controller
{
    public function index()
    {
        $unreadMessagesCount = ContactMessage::where('is_read', false)->count();
        $productsCount = Product::count();
        $categories = Category::withCount('products')->get();
        
        $totalVisitors = Visitor::count();
        $todayVisitors = Visitor::whereDate('created_at', today())->count();

        $syncedProductsCount = \App\Models\MarketplaceLog::where('status', 'success')->count();

        return view('admin.dashboard', compact(
            'unreadMessagesCount', 
            'productsCount', 
            'categories',
            'totalVisitors',
            'todayVisitors',
            'syncedProductsCount'
        ));
    }

    public function visitors()
    {
        $visitors = Visitor::latest()->paginate(25);
        return view('admin.visitors', compact('visitors'));
    }

    public function clearVisitors()
    {
        Visitor::truncate();
        return back()->with('success', 'Tüm ziyaretçi logları başarıyla temizlendi.');
    }
}