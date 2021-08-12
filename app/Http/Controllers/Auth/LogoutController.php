<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
 
class LogoutController extends Controller
{
    public function index(Request $request) {
        $request->user()->currentAccessToken()->delete();

        return response()->json([
            'message' => 'Token has been Revoked',
            'status' => 'success'
        ]);
    }
}
