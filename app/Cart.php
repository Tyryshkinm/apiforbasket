<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    /**
     * Model of adding products to cart
     *
     * @param $request
     * @param $product_id - id of product that need add to cart
     * @param $quantity - quantity of product that need add to cart
     */
    public function addProduct($request, $product_id, $quantity)
    {
        $cart = Cart::select('products', 'total_sum', 'products_count')
            ->where('token', $request->input('token'))
            ->first();
        $product = Product::find($product_id);
        $products = unserialize($cart->products);
        $productsCount = $cart->products_count;
        $totalSum = $cart->total_sum;
        if ($products != null) {
            for ($i = 0; $i < count($products); $i++) {
                if($products[$i]['id'] == (int)$product_id) {
                    $key = $i;
                    break;
                } else {
                    $key = $i + 1;
                }
            }
            if (array_key_exists($key, $products)) {
                $products[$key]['quantity'] = $products[$key]['quantity'] + $quantity;
                $products[$key]['sum'] = $products[$key]['sum'] + $quantity * $product->price;
            } else {
                $products[$key]['id'] = (int)$product_id;
                $products[$key]['quantity'] = $quantity;
                $products[$key]['sum'] = $quantity * $product->price;
            }
            $productsCount = $productsCount + $quantity;
            $totalSum = $totalSum + $quantity * $product->price;
        } else {
            $products[0]['id'] = (int)$product_id;
            $products[0]['quantity'] = $quantity;
            $totalSum = $quantity * $product->price;
            $products[0]['sum'] = $totalSum;
            $productsCount = $quantity;
        }
        $products = serialize($products);
        Cart::where('token', $request->input('token'))
            ->update(
                [
                    'products'       => $products,
                    'total_sum'      => $totalSum,
                    'products_count' => $productsCount
                ]
            );
    }

    /**
     * Model of deleting one quantity product from cart
     *
     * @param $request
     * @param $products - current list of products in the cart
     * @param $product_id - the product id, that need to delete
     * @return int|string
     */
    public function deleteProduct($request, $products, $product_id)
    {
        $cart = Cart::select('total_sum', 'products_count')
                    ->where('token', $request->input('token'))
                    ->first();
        $product = Product::find($product_id);
        for ($i = 0; $i < count($products); $i++) {
            if($products[$i]['id'] == $product_id) {
                $key = $i;
                break;
            } else {
                $key = 'such id not found';
            }
        }
        if ($key === 'such id not found') {
            return $key;
        } else {
            if ($products[$key]['quantity'] != 1) {
                $products[$key]['quantity'] = $products[$key]['quantity'] - 1;
                $products[$key]['sum'] = $products[$key]['sum'] - $product->price;
            } else {
                unset($products[$key]);
            }
        }
        $products = array_values($products);
        $productsCount = $cart->products_count - 1;
        $totalSum = $cart->total_sum - $product->price;
        $products = serialize($products);
        Cart::where('token', $request->input('token'))->update(
            [
                'products'       => $products,
                'total_sum'      => $totalSum,
                'products_count' => $productsCount
            ]
        );

    }
}