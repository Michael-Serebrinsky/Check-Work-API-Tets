<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use Response;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Support\Facades\Log;

class ProductsApiController extends Controller{

    //  *All api calls work with Product Table ( CRUD )

    // Create Product function ( API CALL )
    // And response from paymeservice

    public function createProduct(Request $request){

        // Validation Request 
        $validated = $request->validate([
            'product-name'      => 'required|max:80|alpha_num',
            'product-price'     => 'required|numeric',
            'product-currency'  => 'required|alpha'
        ]);
        
      
        // Create Product Object 
        $product                    = new Product();
        $product->product_name      = $request->input('product-name');
        $product->seller_payme_id   = 'MPL14985-68544Z1G-SPV5WK2K-0WJWHC7N';
        $product->installments      = '1';
        $product->language          = 'en';
        $product->curreny           = $request->input('product-currency');
        $product->price             = $request->input('product-price');
        // Save New Product 
        $newProduct                 = $product->save();  

        // Check if product has benn inserted
        if($newProduct){

            // Varibels for api call     
            if(is_numeric($request->input('product-price'))){
                $price      = $request->input('product-price') * 100;
            }else{
                return response()->json([ 'status' => 'failed','data' => '' ,'message' => 'Product price must be numeric!'], 200);
            }

            $currency   = $request->input('product-currency');
            $prodName   = $request->input('product-name');
            
            // Create New Client Object Guzzle
            $client     = new Client();  
            // Create Data Object        
            $data       = [
                "seller_payme_id"   => "MPL14985-68544Z1G-SPV5WK2K-0WJWHC7N", 
                "sale_price"        => $price, 
                "currency"          => $currency, 
                "product_name"      => $prodName, 
                "installments"      => "1",
                "language"          => "en"
            ];

            // Send api call by try/catch
            try{
                $res    = $client->post('https://preprod.paymeservice.com/api/generate-sale', ['json' => $data ] );
                $status = $res->getStatusCode();

                // If response status 200 ( success )
                if( $status == 200 ){
                    // Decode response json 
                    $dataResponse = json_decode($res->getBody()->getContents());
                    if($dataResponse->status_code === 0){
                        // Update product by payme_sale_code from response 
                        $product->payme_sale_code  = $dataResponse->payme_sale_code;
                        $product->save();
                    }                    
                }else{
                    // Log errors
                    Log::info('Post Request Guzzle Error Status Code Is '.$res->getStatusCode());
                    // Return response   
                    return response()->json([ 'status' => 'failed','data' => '' ,'message' => 'Post Request Guzzle Error Status'], 200);
                }
            }catch(GuzzleException $exceptionn){
                // Log errors
                Log::info('Guzzle Error'. $exceptionn);  
                // Return response         
                return response()->json([ 'status' => 'failed','data' => '' ,'message' => $exceptionn ], 200);  
            }
        }
        // Return response   
        return response()->json([ 'status' => 'success','data' => $dataResponse ,'message' => 'User created!'], 200);
    }
    
    // Delete Product by ID
    public function deleteProduct($id){
        Product::findOrFail($id)->delete();
        $this->responseJson('success', '','Product has benn deleted!');   
    }

    // Update Product
    public function updateProduct(Request $request){
        $product                = Product::findOrFail($request->id);

        $request->validate([
            'product-name'      => 'required|max:80|alpha_num',
            'product-price'     => 'required|numeric',
            'product-currency'  => 'required|alpha'
        ]);

        if(!empty($request->input('product-name'))){
            $product->product_name  = $request->input('product-name');
        }
        if(!empty($request->input('product-currency'))){
            $product->curreny       = $request->input('product-currency');
        }
        if( !empty($request->input('product-price')) ){
            $product->price         = $request->input('product-price'); 
        }
               
        $product->save();
        return response()->json([ 'status' => 'success','data' => '','message' => 'Product has benn updatedet!'], 200);       
    }

    // Get All Products
    public function getAllProducts(){
        $products = Product::get();
        return response()->json([ 'status' => 'success','data' => $products ,'message' => ''], 200);           
    }

    // Get Product by ID
    public function getProduct($id){
        $product  = Product::findOrFail($id);
        return response()->json([ 'status' => 'success','data' => $product ,'message' => ''], 200);             
    }
}
