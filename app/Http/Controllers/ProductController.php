<?php

namespace App\Http\Controllers;
use App\Product;

class ProductController extends Controller
{
    /**
     * Get list of products
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function getProducts()
    {
        $products = Product::select('id', 'name', 'description', 'price')->get();
        return response()->json(['data' => $products]);
    }
}
