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
    public function register(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|min:3',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password)
        ]);

        $token = $user->createToken('pizza-task')->accessToken;
        $users['name'] = $user->name;
        $users['email'] = $user->email;
        $users['address'] = $user->address;
        $users['token'] = $token;
        return $this->sendResponse($users, 'User register successful!', 'US001');
    }

    /**
     * Handles Login Request
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(Request $request)
    {
        $this->validate($request, [
            'email' => 'required',
            'password' => 'required',
            ]);
        $credentials = [
            'email' => $request->email,
            'password' => $request->password
        ];

        if (auth()->attempt($credentials)) {
            $token = auth()->user()->createToken('pizza-task')->accessToken;
            $user_name = auth()->user()->name;
            $user_email = auth()->user()->email;

            $user['name'] = $user_name;
            $user['email'] = $user_email;
            $user['address'] = $user->address;
            $user['token'] = $token;

            return $this->sendResponse($user, 'User Login successful', 'US002');
        } else {
            return $this->sendError('Incorrect', 'Incorrect email or password');
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