<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Product;

class HomeController extends Controller
{
    public function index()
    {
        $products = Product::query()->inRandomOrder()->with('category')->active()
            ->latest()
            ->limit(8)
            ->get();

        $products2 = Product::query()->with('category')->active()
            ->latest()
            ->limit(3)
            ->get();

        $featuredProducts = Product::query()
            ->with('category')
            ->active()
            ->latest()
            ->limit(6)
            ->get()
            ->values();

        $product3 = $featuredProducts->get(0);
        $product4 = $featuredProducts->get(1, $product3);
        $product5 = $featuredProducts->get(2, $product4);
        $product6 = $featuredProducts->get(3, $product5);
        $product7 = $featuredProducts->get(4, $product6);
        $product8 = $featuredProducts->get(5, $product7);

        return view('front.home_en', compact('products', 'products2', 'product3', 'product4', 'product5', 'product6', 'product7', 'product8'));
    }
}
