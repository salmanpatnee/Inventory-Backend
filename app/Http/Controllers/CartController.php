<?php

namespace App\Http\Controllers;

use App\Http\Requests\CartStoreRequest;
use App\Http\Requests\CartUpdateRequest;
use App\Http\Resources\CartResource;
use App\Models\Cart;
use App\Models\Product;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CartController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return CartResource::collection(Cart::all());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CartStoreRequest $request)
    {
        $attributes = $request->validated();

        $product = Product::find($attributes['product_id']);

        $isProductInCart = Cart::where('product_id', $product->id)->first();

        if ($isProductInCart) {

            $isProductInCart->increment('quantity');
            $sub_total = $isProductInCart->quantity * $isProductInCart->unit_price;
            $isProductInCart->update(['sub_total' => $sub_total]);
           
            return response([
                'message' => 'Item already exists.',
                'status'  => 'success'
            ], Response::HTTP_OK);
        } else {
            $cartData['product_id'] = $product->id;
            $cartData['quantity'] = 1;
            $cartData['unit_price'] = $product->price;
            $cartData['sub_total'] = $product->price;

            $cart = Cart::create($cartData);

            $cart['product'] = $product->name;

            return response([
                'data' => $cart,
                'message' => 'Product added successfully.',
                'status'  => 'success',
            ], Response::HTTP_OK);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(CartUpdateRequest $request, Cart $cart)
    {
        $attributes = $request->validated();

        $attributes['sub_total'] = $attributes['quantity'] * $cart->unit_price;

        $cart->update($attributes);

        return response([
            'message' => 'Cart updated successfully.',
            'status'  => 'success',
        ], Response::HTTP_OK);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Cart $cart)
    {
        $cart->delete();

        return response([
            'message' => 'Item deleted successfully.',
            'status'  => 'success'
        ], Response::HTTP_OK);
    }
}
