<?php

namespace App\Http\Controllers\Crud;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Example;

class ReadController extends Controller
{
    public function index() {
        $items = Example::get();

        return response()->json([$items , 'status' => 'success']);
    } 
}
