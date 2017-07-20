<?php

namespace App\Http\Controllers;

use App\Cart;
use App\Product;
use Illuminate\Http\Request;

class CartController extends Controller
{
    /**
     * Controller of adding products to the cart
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function addProductToCart(Request $request)
    {
        $product_id = $request->input('product_id');
        $quantity = $request->input('quantity');
        if (Product::where('id', $product_id)->first() !== null and ($quantity > 0 and $quantity <= 10)) {
            $cart = new Cart;
            $cart->addProduct($request, $product_id, $quantity);
        } else {
            return response()->json([
                'error' => [
                    'params' => [
                        [
                            'code'    => 'required',
                            'message' => 'Product cannot be blank.',
                            'name'    => 'product_id'
                        ],
                        [
                            'code'    => 'required',
                            'message' => 'Quantity cannot be blank.',
                            'name'    => 'quantity'
                        ]
                    ],
                    'type'    => 'invalid_param_error',
                    'message' => 'Invalid data parameters'
                ]
            ], 400);
        }
    }

    /**
     * Controller of deleting one quantity product from cart
     *
     * @param Request $request
     * @param $product_id - the product id, that need to delete
     * @return \Illuminate\Http\JsonResponse
     */
    public function deleteProductFromCart(Request $request, $product_id)
    {
        $cart = Cart::select('products')
                    ->where('token', $request->input('token'))
                    ->first();
        $products = unserialize($cart->products);
        if (Product::where('id', $product_id)->first()) {
            if ($products != null) {
                $cart = new Cart;
                $result = $cart->deleteProduct($request, $products, $product_id);
                if (!empty($result)) {
                    return response()->json(['message' => 'Такого продукта нет в корзине'], 400);
                }
            } else {
                return response()->json(['message' => 'Cart is empty'], 400);
            }
        } else {
            return response()->json(['message' => 'Такого продукта нет в системе'], 400);
        }
    }

    /**
     * Controller of getting list of products in the cart
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getProductsInCart(Request $request)
    {
        $cart = Cart::select('products', 'total_sum', 'products_count')
                    ->where('token', $request->input('token'))
                    ->first();
        $products = unserialize($cart->products);
        if ($products == array()) {
            return response()->json(['message' => 'Cart is empty'],400);
        } else {
            return response()->json([
                'data' => [
                    'total_sum'      => $cart->total_sum,
                    'products_count' => $cart->products_count,
                    'products'       => $products
                ]
            ], 200);
        }
    }
}