<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;
use App\Mail\ResetPassword;
use App\Models\User;

class ForgotPasswordController extends Controller
{
    private $token;

    public function index(Request $request) {
        //validate input
        $isValidatedError = $this->validated($request);

        if($isValidatedError !== null){
            return $isValidatedError;//send json response
        }
        
        //create token for forgot password
        $this->createToken();

        //store data to database
        $this->storeData($request);
        
        //send mail
        $this->sendMail($request);

        //send response
        return response()->json([
            'message' => 'link for reset password has been sended to email',
            'status' => 'success',
        ]);
    }

    private function validated($request) {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
        ]);

        if ($validator->fails()) {
            $responseArr['message'] = $validator->errors();;
            return response()->json($responseArr);
        }

        $check = User::where('email', $request->email)->first();

        if($check == null) {
            return response()->json([
                'message' => "email hasn't in record",
                'status' => 'failed'
            ]);
        }
    }

    private function createToken() {
         //create token for forgot password
          $this->token = STR::random(64);
    }
    
    private function storeData($request) {
          //store to db
          \DB::table('password_resets')->insert([
              'email' => $request->email, 
              'token' => $this->token, 
              'created_at' => now()
          ]);
    }

    private function sendMail($request) {
        Mail::to($request->email)
        ->send(new ResetPassword($this->token));
    }
}
