<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ConfirmationController extends Controller
{
    public function index($orderID){
        return view('ConfirmationPage', ['orderID' => $orderID]); 
    }
}
