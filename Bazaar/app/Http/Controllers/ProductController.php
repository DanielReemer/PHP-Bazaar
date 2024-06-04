<?php

namespace App\Http\Controllers;

use App\Models\BoughtProduct;
use App\Models\HiredProduct;
use Illuminate\Support\Facades\Auth;

class ProductController extends Controller
{
    public function show(?string $type = 'hired') {
        $products = null;

        if($type == 'hired') {
            $products = HiredProduct::where('user_id', Auth::id())
                ->with('user')
                ->with('advert')
                ->get();
        } else {
            $products = BoughtProduct::where('user_id', Auth::id())
                ->with('user')
                ->with('advert')
                ->get();
        }

        $data = [
            'type' => $type,
            'products' => $products,
        ];

        return view('products.navigation', compact('data'));
    }
}
