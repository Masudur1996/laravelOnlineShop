<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Cart;

class CartController extends Controller
{

    //for showing cart page
    public function cart()
    {

        $cartItems = Cart::content();
        //Cart::destroy();
        // dd($cartItems);
        return view('front.cart', compact('cartItems'));
    }

    //for add product in cart
    public function addToCart(Request $request)
    {

        $product = Product::with('product_images')->find($request->id);
        if (!$product) {
            return response()->json([
                'status' => false,
                'message' => 'Product Not Found'
            ]);
        } else {

            if (Cart::count() > 0) {

                // $cartContent = Cart::content()->pluck('id')->toArray();
                // $rrr = in_array($request->id, $cartContent);
                // //dd($rrr);

                // if ($rrr) {
                //     return response()->json([
                //         'status' => false,
                //         'message' => 'Product already in cart'
                //     ]);
                // } else {
                //     Cart::add($product->id, $product->name, 1, $product->price, ['image' => (!empty($product->product_images)) ? $product->product_images->first() : " "]);
                //     return response()->json([
                //         'status' => true,
                //         'message' => 'Product added in cart'
                //     ]);
                // }
                $cartContent = Cart::content();
                foreach ($cartContent as $item) {
                    if ($item->id == $product->id) {
                        return response()->json([
                            'status' => false,
                            'message' => 'Product already in cart'
                        ]);
                    } else {
                        Cart::add($product->id, $product->name, 1, $product->price, ['image' => (!empty($product->product_images)) ? $product->product_images->first() : " "]);
                    }
                }
            } else {

                Cart::add($product->id, $product->name, 1, $product->price, ['image' => (!empty($product->product_images)) ? $product->product_images->first() : " "]);
                return response()->json([
                    'status' => true,
                    'message' => 'Product added in cart'
                ]);
            }
        }
    }
}
