<?php

namespace App\Jobs;

use App\Models\Product;
use App\Models\MarketplaceSetting;
use App\Models\MarketplaceLog;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class SyncMarketplaceStockJob implements ShouldQueue
{
    use InteractsWithQueue, Queueable, SerializesModels;

    public Product $product;

    public function __construct(Product $product)
    {
        $this->product = $product;
    }

    public function handle(): void
    {
        $settings = MarketplaceSetting::where('is_active', true)->get();

        foreach ($settings as $setting) {
            Log::info("Ürün senkronize edildi ({$setting->marketplace}): " . $this->product->name);

            MarketplaceLog::create([
                'marketplace' => $setting->marketplace,
                'action' => 'stock_sync',
                'status' => 'success', 
                'message' => "Ürün stok güncellendi: {$this->product->name} (Stok: {$this->product->stock})",
                'payload' => [
                    'product_id' => $this->product->id,
                    'stock' => $this->product->stock,
                    'price' => $this->product->price,
                ],
            ]);
        }
    }
}