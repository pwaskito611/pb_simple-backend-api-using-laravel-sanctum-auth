<?php

namespace App\Http\Controllers\Crud;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Example;

class DeleteController extends Controller
{
    public function index(Request $request) {

        $item = Example::findOrFail($request->id);
        $item->delete();

        return response()->json([
            'message' => 'data is deleted',
            'status' => 'success'
        ]);
    } 
}
