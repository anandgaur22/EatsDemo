<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth; 
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\URL;
use Illuminate\Routing\UrlGenerator;
use App\UserRegister;
use App\Slider;
use Validator;

class ApiController extends Controller
{
    //

    public function userRegister(Request $request)
    {
        
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required',
            'mobile_no' => 'required',
            'device_type' => 'required',
            'device_id' => 'required',
            'device_token' => 'required'
       ]);

        if($validator->fails()){

            return response()->json(["status" =>"false","message" =>"Enter all field required first"],400);
        }


        $validator = Validator::make($request->all(), [
            'email' => 'unique:user_register'
       ]);

        if($validator->fails()){

            return response()->json(["status" =>"false","message" =>"This email is already register"],400);
        }

        $validator = Validator::make($request->all(), [
            'mobile_no' => 'unique:user_register'
       ]);

        if($validator->fails()){

            return response()->json(["status" =>"false","message" =>"This mobile number is already register"],400);
        }

        $userRegister =new UserRegister();

        $userRegister->name =$request->input('name');
        $userRegister->email=$request->input('email');
        $userRegister->mobile_no=$request->input('mobile_no');
        $userRegister->device_type=$request->input('device_type');
        $userRegister->device_id=$request->input('device_id');
        $userRegister->device_token=$request->input('device_token');
        $userRegister->refferal_code=$request->input('refferal_code');

        $userRegister->save();
   
        return response()->json(["status" =>"true","message" =>"You are register successfully","data" =>$userRegister->only(['id', 'name', 'email', 'mobile_no'])],200);
    }


    public  function userLogin(Request $request)
    {
        
        $validator = Validator::make($request->all(), [
            'mobile_no' => 'required',
            'device_type' => 'required',
            'device_id' => 'required',
            'device_token' => 'required'
       ]);
           
       if ($validator->fails()) {
          return response()->json(["status" =>"false","message" =>"Enter all field required first"],404);
     }

        $userRegister = UserRegister::where('mobile_no', $request->mobile_no)->first();

        if ($userRegister) {

            UserRegister::where('mobile_no', $request->mobile_no)->update(['device_type' => 
            $request->device_type,'device_id' => $request->device_id,'device_token' 
            => $request->device_token]);

            return response()->json(["status" =>"true","message" =>"You are login successfully","data" =>$userRegister->only(['user_id','name', 'email', 'mobile_no'])],200);

        } else {
            return response()->json(["status" =>"false","message" => "You are not register"],404);

        }
   
    }




}
