<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Product;
use Illuminate\Http\Request;
use Psy\Readline\Hoa\Console;
use Tymon\JWTAuth\Facades\JWTAuth;

class CartController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api');
    }

    public function index()
    {
        $carts = Cart::with('product.images')->where('user_id',JWTAuth::user()->id)->get();

        return response()->json($carts);
    }


    public function store(Request $request)
    {
        $product_id = $request->input('product_id');
        $user_id = JWTAuth::user()->id;
        if(!Product::find($product_id)){
            return response()->json(['message'=>'product not found']);
        }

        if(Cart::where('product_id',$product_id)->where('user_id',$user_id)->first()){
            return response()->json(['message'=>'Already in cart']);
        }

        $credentials = [
            'user_id' => $user_id,
            'product_id' =>$product_id,
        ];

        $cart = Cart::create($credentials);

        return response()->json(['message'=>'added to cart']);
    }

    public function destroy(Cart $cart)
    {
        $cart->delete();
        response()->json(['message'=>'product removed']);
    }
}
