<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Support\Facades\Log;

class SaleController extends Controller{
    public function index(){
        $products = Product::all();
        return view('index', [ 'produsts' => $products ]);
    }
}   
