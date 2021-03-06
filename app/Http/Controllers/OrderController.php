<?php

namespace App\Http\Controllers;

use App\Cart;
use App\Order;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Log;
use Response;
use Validator;
use App\User;
use Dotenv\Store\File\Reader;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        try {
            $email = Cache::get('email'.$request->email.'');

            if(isset($email)){

                $orders = Cart::where('email', $email)->get();

                return $this->sendResponse($orders, 'Orders Retrieve successful');
            }else{
                return $this->sendError('No Order Yet', 'You have not placed any order yet!');
            }
        }catch(\Exception $e){
           Log::error('Error in getting orders for user : '.$e);
       }
    }

//    public function getOrderItems(Request $request){
//        $this->validate($request, [
//            'order_id' => 'required',
//            'user_id' => 'required',
//        ]);
//        if(Cart::where('user_id', '=', $request->user_id)->count() == 0){
//            return $this->sendError('No Items', 'This order do not belong to you!');
//        }
//        try{
//        $items = Cart::where('order_id', $request->order_id)->get();
//            return $this->sendResponse($items, 'Order Items Retrieve successful');
//            }catch(\Exception $e){
//        Log::error('Error in getting items of order : '.$e);
//        }
//    }
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
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function show(Order $order)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function edit(Order $order)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Order $order)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function destroy(Order $order)
    {
        //
    }
}
