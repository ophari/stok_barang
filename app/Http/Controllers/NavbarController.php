<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class NavbarController extends Controller
{
    public function getLowStockNotifications()
    {
        $lowStockProducts = Product::where('stock', '<=', 5)
            ->select('id', 'name', 'stock')
            ->get();

        return response()->json($lowStockProducts);
    }
}


