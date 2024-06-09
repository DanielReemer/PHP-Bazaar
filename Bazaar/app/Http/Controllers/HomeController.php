<?php

namespace App\Http\Controllers;

use App\Models\Advert;

class HomeController extends Controller
{
    public function index() {
        $adverts = Advert::orderBy('created_at', 'desc')
            ->paginate(10);

        return view('home', compact('adverts'));
    }
}
