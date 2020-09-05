<?php

namespace App\Http\Controllers;

use App\Cart;
use App\Order;
use App\User;
use Log;
use Response;
use Validator;
use Illuminate\Http\Request;

class CartController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //

    }

    /**
     * Store a newly created resource in storage.
     *'name', 'price', 'photo', 'quantity', 'product_id', user_id
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

     try{
         $validate = Validator::make($request->data,[
             'item_count' => 'required|integer',
             'user_id' => 'required',
             'total_amount_in_dollars' => 'required',
             'total_amount_in_euros' => 'required',
             'address' => 'required',
             'shipping_fees' => 'required',
             'phone_number' => 'required',
         ]);
         if($validate->fails()){
             return $this->sendError('Validations Error', $validate->errors());
         }
        $order_code = mt_rand(2, 909);
        $order_id_code = 'ORD'.$order_code;
        $order = new Order;
        $order->item_count = $request->data['item_count'];
        $order->order_id = $order_id_code;
        $order->user_id = $request->data['user_id'];
        $order->total_amount_in_dollars = $request->data['total_amount_in_dollars'];
        $order->total_amount_in_euros = $request->data['total_amount_in_euros'];
        $order->shipping_address = $request->data['address'];
        $order->shipping_fees = $request->data['shipping_fees'];
        $order->phone_number = $request->data['phone_number'];
        $order->save();


        foreach ($request->cartItems as $carts) {

            $validate = Validator::make($carts,[
                'name' => 'required',
                'price' => 'required',
                'photo' => 'required',
                'quantity' => 'required|integer',
                'id' => 'required',
            ]);

            if($validate->fails()){
                 return $this->sendError('Validations Error', $validate->errors());
            }

            $cart = new Cart();
            $cart->name = $carts['name'];
            $cart->price = $carts['price'];
            $cart->photo = $carts['photo'];
            $cart->quantity = $carts['quantity'];
            $cart->product_id = $carts['id'];
            $cart->user_id = $request->data['user_id'];
            $cart->order_id = $order_id_code;
            $cart->save();
        }

        $user = User::find($request->data['user_id']);
        $user->address = $request->data['address'];
        $user->phone_number = $request->data['phone_number'];
        $user->save();

        return $this->sendResponse($cart, 'Orders placed successful', 'OD001');
      }catch(\Exception $e){
          Log::error('Error in checking out : '.$e);
      }

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Cart  $cart
     * @return \Illuminate\Http\Response
     */
    public function show(Cart $cart)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Cart  $cart
     * @return \Illuminate\Http\Response
     */
    public function edit(Cart $cart)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Cart  $cart
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Cart $cart)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Cart  $cart
     * @return \Illuminate\Http\Response
     */
    public function destroy(Cart $cart)
    {
        //
    }
}
