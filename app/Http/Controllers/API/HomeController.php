<?php 

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;

class HomeController extends Controller{
    public function index(){
        return response()->json(['message' => 'Welcome to home']);
    }
}