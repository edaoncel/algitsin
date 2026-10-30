<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\MarketplaceSetting;
use App\Models\MarketplaceLog;
use App\Models\Product;
use App\Jobs\SyncMarketplaceStockJob;
use Illuminate\Http\Request;

class MarketplaceController extends Controller
{
    public function settings()
    {
        $settings = MarketplaceSetting::all()->keyBy('marketplace');

        return view('admin.marketplaces.settings', compact('settings'));
    }

    public function updateSettings(Request $request, string $marketplace)
    {
        $validated = $request->validate([
            'is_active' => 'nullable|boolean',
            'merchant_id' => 'required|string',
            'api_key' => 'required|string',
            'api_secret' => 'required|string',
            'price_margin_percent' => 'nullable|numeric|min:0',
        ]);

        $validated['is_active'] = $request->has('is_active');

        MarketplaceSetting::updateOrCreate(
            ['marketplace' => $marketplace],
            $validated
        );

        return back()->with('success', ucfirst($marketplace) . ' ayarları başarıyla güncellendi.');
    }

    public function logs(Request $request)
    {
        $query = MarketplaceLog::latest();

        if ($request->filled('marketplace')) {
            $query->where('marketplace', $request->marketplace);
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $logs = $query->paginate(30);

        return view('admin.marketplaces.logs', compact('logs'));
    }

    public function syncAll()
    {
        $products = Product::where('is_active', true)->get();

        foreach ($products as $product) {
            SyncMarketplaceStockJob::dispatch($product);
        }

        return back()->with('success', 'Tüm ürünler için pazaryeri stok senkronizasyonu kuyruğa eklendi.');
    }
}