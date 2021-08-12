<?php

namespace App\Http\Controllers\Crud;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Example;

class CreateController extends Controller
{
    public function index(Request $request) {
        //valudate input
        $isValidatedError = $this->validated($request);

        if($isValidatedError !== null){
            return $isValidatedError;//send json response
        }

        $this->storeToDB($request);

        //send response
        return response()->json([
            'message' => 'data is stored',
            'status' => 'success'
        ]);
    }

    private function validated($request) {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'value' => 'required',

        ]);

        
        if ($validator->fails()) {
            $responseArr['message'] = $validator->errors();;
            return response()->json($responseArr);
        }

    }

    private function storeToDB($request) {
        $item = new Example;
        $item->name = $request->name;
        $item->value = $request->value;
        $item->save();
    }
}
