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
        $data = [
            'type' => $type,
            'products' => null,
        ];

        return view('products.navigation', compact('data'));
    }
}
