<?php

namespace App\Http\Controllers\Crud;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Example;

class UpdateController extends Controller
{
    public function index(Request $request) {

        //validate input
        $isValidatedError = $this->validated($request);

        if($isValidatedError !== null){
            return $isValidatedError;//send json response
        }

        //update data in database
        $this->updateData($request);

        //send response
        return response()->json([
            'message' => 'data is updated',
            'status' => 'success'
        ]);
    }

    private function validated($request) {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'value' => 'required',
            'id' => 'required|integer',
        ]);

        
        if ($validator->fails()) {
            $responseArr['message'] = $validator->errors();;
            return response()->json($responseArr, 400);
        }

    }

    private function updateData($request) {
        $item = Example::findOrFail($request->id);
        $item->name = $request->name;
        $item->value = $request->value;
        $item->save();
    }
}
