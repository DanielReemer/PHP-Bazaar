<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Advert;
use App\Models\HiredProduct;
use App\Models\BoughtProduct;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function show(?string $type = 'hired')
    {
        $products = $this->getProducts($type);

        $data = [
            'type' => $type,
            'products' => $products,
        ];

        return view('products.navigation', compact('data'));
    }

    private function getProducts(string $type)
    {
        $products = null;
        $user = Auth::user();
        
        switch ($type) {
            case 'hired':
                $products = HiredProduct::where('user_id', Auth::id())
                    ->with('user')
                    ->with('advert')
                    ->get();
                break;
            case 'bought':
                $products = BoughtProduct::where('user_id', Auth::id())
                    ->with('user')
                    ->with('advert')
                    ->get();
                break;
            case 'hired_out':
                $products = HiredProduct::whereHas('advert', function ($advert) use ($user) {
                    $advert->whereBelongsTo($user, 'owner');
                })
                    ->with('user')
                    ->with('advert')
                    ->get();
                break;
            default:
                abort(404);
        }

        return $products;
    }
}
