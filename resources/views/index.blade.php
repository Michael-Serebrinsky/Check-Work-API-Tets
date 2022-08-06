<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    @extends('layouts.header')
    <body class="body">
       <div class="container">
            <div class="row">
                <div class="col-sm-12 mt-5">
                    <table class="table table-striped">
                        <thead class="bg-dark text-white">
                          <tr>
                            <th scope="col">#</th>
                            <th scope="col">Product</th>
                            <th scope="col">Time</th>
                            <th scope="col">Price</th>
                            <th scope="col">Currency</th>
                            <th scope="col">PaYme Sale Code</th>
                          </tr>
                        </thead>
                        <tbody>
                            @if(!empty($produsts))
                                @foreach($produsts as $prod)
                                    <tr>
                                        <th>{{$prod->id}}</th>
                                        <th>{{$prod->product_name}}</th>
                                        <th>{{$prod->created_at}}</th>
                                        <th>{{$prod->price}}</th>
                                        <th>{{strtoupper($prod->curreny)}}</th>
                                        <th>{{$prod->payme_sale_code}}
                                    </tr>
                                @endforeach
                            @endif
                        </tbody>
                      </table>
                </div>
            </div>
       </div>
    @extends('layouts.footer')  
    </body>
</html>
