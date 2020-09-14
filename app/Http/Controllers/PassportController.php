<?php

namespace App\Http\Controllers;

use App\User;
use App\Cart;
use Illuminate\Http\Request;

class PassportController extends Controller
{
    /**
     * Handles Registration Request
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function register($data)
    {

        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
            'address' => $data['address'],
            'phone_number' => $data['phone_number'],
        ]);

        $token = $user->createToken('pizza-task')->accessToken;
        $users['name'] = $user->name;
        $users['email'] = $user->email;
        $users['address'] = $user->address;
        $users['user_id'] = $user->id;
        $users['address'] = $user->address;
        $users['phone_number'] = $user->address;
        $users['token'] = $token;
        $users['phone_number'] = $user->phone_number;
        return $users;
    }

    /**
     * Handles Login Request
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function login($data)
    {
        $credentials = [
            'email' => $data['email'],
            'password' => $data['password']
        ];

        if (auth()->attempt($credentials)) {
            $token = auth()->user()->createToken('pizza-task')->accessToken;
            $user_name = auth()->user()->name;
            $user_email = auth()->user()->email;
            $user_address = auth()->user()->address;
            $user_id = auth()->user()->id;
            $phone_number = auth()->user()->phone_number;

            $user['name'] = $user_name;
            $user['email'] = $user_email;
            $user['address'] = $user_address;
            $user['user_id'] = $user_id;
            $user['token'] = $token;
            $user['phone_number'] = $phone_number;

            return $user;
        } else {
            return 'Incorrect';
        }
    }

    /**
     * Returns Authenticated User Details
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function details()
    {
        return response()->json(['user' => auth()->user()], 200);
    }

    public function saveAddress(Request $request){
        $this->validate($request,[
           'address' => 'required',
        ]);
       $user_id = 1;
       $user = User::find($user_id);
       $user->address =  $request->address;
       if($user->save())
       {
           return $this->sendResponse('Save successful', 'Shipping address save successful', 'US003');
       }else{
           return $this->sendError('Error', 'shipping address not save.');
       }
    }
}