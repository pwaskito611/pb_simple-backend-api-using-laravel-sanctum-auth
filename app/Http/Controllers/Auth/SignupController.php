<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Models\User;

class SignupController extends Controller
{
    private $user;

    public function index(Request $request) {
        
        //validate input
        $isValidatedError = $this->validated($request);

        if($isValidatedError !== null){
            return $isValidatedError;//send json response
        }

        //store user input to database
        $this->storeToDatabase($request);


        //send response
        $response = [
            'email' => $this->user->email,
            'name' => $this->user->name,
            'token' => $this->createToken(),
            'status' => 'success',

        ];

        return response()->json($response);
    }

    private function validated($request) {
        $validator = Validator::make($request->all(), [
            'email' => 'required|unique:users|email',
            'name' => 'required|max:50',
            'password' => 'required|confirmed|min:8',

        ]);

        
        if ($validator->fails()) {
            $responseArr['message'] = $validator->errors();;
            return response()->json($responseArr);
        }

    }

    private function storeToDatabase($request){
         //store data to db
         $this->user = new User;
         $this->user->email = $request->email;
         $this->user->name = $request->name;
         $this->user->password = Hash::make($request->password);
         $this->user->save();
    }

    private function createToken() {
        return $token = $this->user->createToken('MyApp')->plainTextToken;
    }
}
