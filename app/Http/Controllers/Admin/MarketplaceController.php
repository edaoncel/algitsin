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

public function logs()
{
    $activeMarketplaces = MarketplaceSetting::where('is_active', true)->pluck('marketplace');

    $logs = MarketplaceLog::whereIn('marketplace', $activeMarketplaces)
                ->orderBy('created_at', 'desc')
                ->paginate(20);

    return view('admin.marketplaces.logs', compact('logs'));
}
}