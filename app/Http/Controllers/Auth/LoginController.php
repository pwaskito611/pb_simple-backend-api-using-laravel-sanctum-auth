<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Models\User;

class LoginController extends Controller
{
    public function index(Request $request) {
        //validate input
        $isValidatedError = $this->validated($request);

        if($isValidatedError !== null){
            return $isValidatedError;//send fail json response
        }

        return $this->authentication($request);

    }

    private function validated($request) {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required|min:8',

        ]);

        
        if ($validator->fails()) {
            $responseArr['message'] = $validator->errors();;
            return response()->json($responseArr);
        }

    }

    private function authentication($request) {
        $user = User::where('email', $request->email)->first();//get user data

        if($user !== null) {
            if (Hash::check($request->password, $user->password)) {
                $token = $user->createToken('MyApp')->plainTextToken;

                $response = [
                    'email' => $user->email,
                    'name' => $user->name,
                    'token' => $token,
                    'status' => 'success',        
                ];

                return response()->json($response);
            }
        }

        return response()->json([
            'message' => 'your email or password is wrong',
            'status' => 'failed'
        ]);
    }
}
