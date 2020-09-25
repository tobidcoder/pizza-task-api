<?php

namespace App\Http\Controllers;

use App\User;
use App\Cart;
use Log;
use Response;
use Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Hash;




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
//        return $request;
//        $input = $request;
        try{
            $validate = Validator::make($request->data,[
                'name' => 'required',
                'phone_number' => 'required',
                'email' => 'required|email|unique:users',
                'address' => 'required',
                'password' => 'required',
            ]);

        if($validate->fails()){
            return $this->sendError('Validations Error', $validate->errors());
        }

        $user = User::create([
            'name' => $request->data['name'],
            'email' => $request->data['email'],
            'password' => bcrypt($request->data['password']),
            'address' => $request->data['address'],
            'phone_number' => $request->data['phone_number'],
        ]);
      if($user) {
          $token = $user->createToken('pizza-task')->accessToken;
          $users['name'] = $user->name;
          $users['email'] = $user->email;
          $users['address'] = $user->address;
          $users['user_id'] = $user->id;
          $users['address'] = $user->address;
          $users['token'] = $token;
          $users['phone_number'] = $user->phone_number;

          Cache::forever('email'.$request->data['email'].'', $request->data['email']);

          return $this->sendResponse($users, 'User Register successful!', 'OD005');
      } else {
             return $this->sendError('Error', 'something went wrong!');
       }

       }catch(\Exception $e){
                Log::error('Error in Register user : '.$e);
            }
    }

    /**
     * Handles Login Request
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(Request $request)
    {
//        return $request;
//        $input = $request->data;
//        return $input;
        try{
            $validate = Validator::make($request->data,[
                'email' => 'required',
                'password' => 'required',
            ]);

            if($validate->fails()){
                return $this->sendError('Validations Error', $validate->errors());
            }

            $login = User::where('email', $request->data['email'])->first();
            if ($login) {
                $passowrd_check = Hash::check($request->password, $login->password);

                if(!$passowrd_check){

                    return $this->sendError('Incorrect password', ['error' => 'Incorrect Password']);

                }
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

                  Cache::forever('email'.$request->data['email'].'', $request->data['email']);

                return $this->sendResponse($user, 'User Login successful!', 'OD006');

            } else {
                return $this->sendError('Error', 'Email or password not correct!');
            }

          }catch(\Exception $e){
             Log::error('Error in user login : '.$e);
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