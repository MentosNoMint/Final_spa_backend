<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Models\users;
use Illuminate\Support\Facades\Validator;
class usersController extends Controller
{
    public function register(Request $request)
    {
        $validator = Validator::make($request->all() , [
            'first_name' => 'required',
            'last_name' => 'required',
            'phone' => 'required|unique:users',
            'document_number' => 'required|numeric|digits:10',
            'password' => 'required'
        ]);

        if($validator->fails()){
            return response()->json([
                'error' => [
                    'code' => 422,
                    'message' => 'Validation error',
                    'errors' => $validator->errors()
                    ]
            ], 422);
        }
        users::create($request->all());
        return response()->json()->setStatusCode(204);
    }


    public function login(Request $request)
    {
        $validator = Validator::make($request->all() , [
            'phone' => 'required',
            'password' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'error' => [
                    'code' => 422,
                    'message' => 'Validation error',
                    'errors' => $validator->errors()
                ]
            ], 422);
        }

        if($user = users::where('phone' , $request->phone)->first()){
            if($user->password === $request->password){
                return
                response()->json([
                    'data' => [
                        'token' => $user->generateToken()
                    ]
                ]);
            }
        }


        return response()->json([
            'error' => [
                'code' => 401,
                'message' => 'Unauthorized',
                'errors' => [
                    'phone' => ['phone or password incorrect']
                ]
            ]
        ],401);
    }
}
