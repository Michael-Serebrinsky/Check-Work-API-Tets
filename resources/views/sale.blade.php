<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    @extends('layouts.header')
    <body class="body">
       <div class="container">
            <div class="row">
                <div class="col-sm-12 mt-5" id="form-wrapper">
                    <div><a href="/sales">History</a></div>
                    <div id="btn-back-to-form" ><button type="button">Open Pay Form</button></div>
                    <form id="buy-now-form" class="card" method="POST" action="/api/">
                        @csrf
                        <img src="{{ URL::to('/') }}/images/banner.jpg" class="card-img-top" alt="banner">
                        <div class="card-body">
                          <h5 class="card-title text-center">New Sale</h5>
                          <div class="card-text">
                                <label for="product-name">Product name</label>
                                <input type="text" name="product-name" class="form-control">
                          </div>
                          <div class="card-text">
                            <label for="product-price">Price</label>
                            <input type="text" name="product-price" class="form-control">
                          </div>
                          <div class="card-text">
                            <label for="product-currency">Currency</label>
                            <select name="product-currency" id="product-currency" class="form-control">
                                <option value="ils" selected >ILS</option>
                                <option value="usd">USD</option>
                                <option value="eur">EUR</option>
                            </select>
                          </div>
                          <div class="card-text mt-3">
                            @if ($errors->any())
                                <div class="alert alert-danger">
                                    <ul>
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif
                            <button type="submit" class="btn btn-primary">Buy Now</button>
                          </div>                          
                        </div>
                      </div>
                    </form>
            </div>
       </div>

  <!-- Modal Iframe -->      
  <div id="mymodal" class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
          <div class="modal-header">
            <h3 class="text-center">PayMe Form </h3>
          </div>
          <div class="modal-body">
            <iframe id="iframe-payme" src="" frameborder="0"></iframe>
          </div>
      </div>
    </div>
  </div>
    @extends('layouts.footer')  
    </body>
</html>
