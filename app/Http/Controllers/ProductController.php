<?php

namespace App\Http\Controllers;
use App\Product;

class ProductController extends Controller
{
    public function getProducts()
    {
        $products = Product::select('id', 'name', 'description', 'price')->get();
        return response()->json(['data' => $products]);
    }
}
