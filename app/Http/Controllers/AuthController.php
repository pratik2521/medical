<?php

namespace App\Http\Controllers;
use App\Http\Controllers\BaseController as BaseController;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\FormObjectType;
use Illuminate\Support\Facades\Hash;
use Symfony\Component\HttpFoundation\Response;


class AuthController extends BaseController
{ 
    public function register(Request $request)
    {
        $this->validate($request, [
            'firstName' => 'required|min:4',
            'lastName' => 'required',
            'mobileNo' => 'required|digits:10',
            'email' => 'required|email|unique:users',
            'password' => [
                'required',
                'min:6',
                'regex:/^.*(?=.{3,})(?=.*[a-zA-Z])(?=.*[0-9])(?=.*[\d\x])(?=.*[!$#%]).*$/',
            ],
            'c_password' => 'required|same:password',
        ]);
 
        $user = User::create([
            'firstName' => $request->firstName,
            'lastName' => $request->lastName,
            'mobileNo' => $request->mobileNo,
            'email' => $request->email,
            'password' => bcrypt($request->password)
        ]);
       
        $data['token'] = $user->createToken('MedicalBreakThoughApp')->accessToken;
        $this->setResponseCode(201);
        $this->apiResponse['message'] ='User Register successfully';
        $this->apiResponse['result'] = $data;
        return $this->sendResponse();
    }
 
    public function login(Request $request)
    {
        $this->validate($request, [
            'email' => 'required',
            'password' => 'required',
        ]);
        // print_r(FormObjectType::all());die;
        $data = [
            'email' => $request->email,
            'password' => $request->password
        ];
 
        if (auth()->attempt($data)) {
            $response['token'] = auth()->user()->createToken('MedicalBreakThoughApp')->accessToken;
            $response['user_id']=auth()->user()->id;
            $this->setResponseCode(200);
            $this->apiResponse['message'] ='Login Successfully';
            $this->apiResponse['result'] = $response;
        } else {
            $this->setResponseCode(401);
            $this->apiResponse['message'] ='Unauthorised';
        }
        return $this->sendResponse();
    }  
}
