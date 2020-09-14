<?php

namespace App\Http\Controllers;

use App\Cart;
use App\Order;
use App\User;
use Log;
use Response;
use Validator;
use App\Http\Controllers\PassportController as Passport;
use Illuminate\Http\Request;

class CartController extends Controller
{


//    public Passport = $this->passport;

    /** @var   */
    private $passport;

    public function __construct(Passport $passport)
    {
        $this->passport = $passport;
    }
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

         if(isset($request->data['name']) && isset($request->data['email'])) {
             $validate = Validator::make($request->data,[
                 'name' => 'required',
                 'phone_number' => 'required',
                 'email' => 'required|email|unique:users',
                 'currency' => 'required',
                 'address' => 'required',
                 'password' => 'required',
             ]);

            if($validate->fails()){
             return $this->sendError('Validations Error', $validate->errors());
           }

             $user = $this->passport->register($request->data);
         }elseif(isset($request->data['email'])){
             $validate = Validator::make($request->data,[
                 'email' => 'required',
                 'currency' => 'required',
                 'password' => 'required',
             ]);

             if($validate->fails()){
                 return $this->sendError('Validations Error', $validate->errors());
             }

             $user = $this->passport->login($request->data);
             if($user === 'Incorrect'){
                 return $this->sendError('incorrect', 'Email or password is incorrect!');
             }

         }


        $order_code = mt_rand(2, 909);
        $order_id_code = 'ORD'.$order_code;
        $order = new Order;
        $order->item_count = $request->itemCount;
        $order->order_id = $order_id_code;
         if($request->user_id){
             $order->user_id = $request->user_id;
             $users = User::find($request->user_id);
             $order->shipping_address = $users->address;
             $order->phone_number = $users->phone_number;
         }else{
             $order->user_id = $user['user_id'];
             $order->shipping_address = $user['address'];
             $order->phone_number = $user['phone_number'];
         }
        $order->currency = $request->data['currency'];
        $order->total_amount = $request->total;
        $order->shipping_fees = $request->shippingFees;
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
            $cart->currency = $request->data['currency'];
            $cart->photo = $carts['photo'];
            $cart->quantity = $carts['quantity'];
            $cart->product_id = $carts['id'];
            if($request->user_id){
                $cart->user_id = $request->user_id;
            }else{
                $cart->user_id = $user['user_id'];
            }

            $cart->order_id = $order_id_code;
            $cart->save();
        }
//        return $user;

        return $this->sendResponse($user, 'Orders placed successful', 'OD001');
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
