<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Exception;

class NavbarController extends Controller
{
    public function getLowStockNotifications()
    {
        try {
            $lowStockProducts = Product::where('stock', '<=', 5)
                ->select('id', 'name', 'stock')
                ->get();

            return response()->json($lowStockProducts);
        } catch (Exception $e) {
            return response()->json([
                'error' => 'Failed to retrieve low stock notifications: ' . $e->getMessage()
            ], 500);
        }
    }
}
