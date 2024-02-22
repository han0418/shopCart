@extends('layouts.app') 
@section('title', $product->title) 
@section('content')
    <div class="card">
        <div class="card-body product-info">
            <div class="row">
                <div class="col-sm-5">
                    <img class="img-fluid" src="{{ $product->image_url }}" alt="{{ $product->title }}">
                </div>
                <div class="col-sm-7">
                    <div class="h2">{{ $product->title }}</div>
                    <div class="h3"> {{ $product->price }}dollars</div>
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text">Quantity</span>
                        </div>
                        <input type="text" class="form-control input-sm" name="amount" value="1">
                        <div class="input-group-append">
                            <button class="btn btn-primary btn-add-to-cart" data-id="{{ $product->id }}">Add To Cart</button>
                        </div>
                    </div>                        
                    {!! $product->description !!}
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scriptsAfterJs')
    <script>
        $(document).ready(function() {
            @include('product.add_to_cart')
        });
    </script>
@endsection
