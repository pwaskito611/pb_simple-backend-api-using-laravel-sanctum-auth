<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Models\User;

class ResetPasswordController extends Controller
{
    private $check;

    public function index(Request $request) {
        //valiate user input
        $isValidatedError = $this->validated($request);

        if($isValidatedError !== null){
            return $isValidatedError;//send json response
        }

        //update password to databases
        $this->updateDataToDatabase($request);

        //send response
        return response()->json([
            'message' => 'password has been reseted',
            'status' => 'success'
        ]);
        
    }

    private function validated($request) {
        $validator = Validator::make($request->all(), [
            'token' => 'required',
            'password' => 'required|min:8|confirmed',
        ]);

        if ($validator->fails()) {
            $responseArr['message'] = $validator->errors();;
            return response()->json($responseArr);
        }

        $this->check = \DB::table('password_resets')
                ->where('token', $request->token)
                ->first();

        if($this->check == null) {
            return response()->json([
                'message' => "email hasn't in record",
                'status' => 'failed'
            ]);
        }
    }

    private function updateDataToDatabase($request) {
        //update password to db
        $reset = User::where('email', $this->check->email)->first();
        $reset->password = Hash::make($request->password);
        $reset->save();
    }
}
