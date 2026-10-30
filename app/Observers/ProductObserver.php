<?php

namespace App\Observers;

use App\Models\Product;
use App\Jobs\SyncMarketplaceStockJob;

class ProductObserver
{

    public function updated(Product $product): void
    {
        if ($product->isDirty('stock') || $product->isDirty('price')) {
            SyncMarketplaceStockJob::dispatch($product);
        }
    }

    public function created(Product $product): void
    {
        //
    }
}