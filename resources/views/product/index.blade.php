@extends('layouts.app')
@section('content')
    <h1>Product</h1>
    <div class="card-deck">
        @forelse($products->where('on_sale', true) as $product)
            <div class="card mb-4">
                    <img src="{{ $product->image_url }}" class="card-img-top" alt="{{ $product->title }}">
                <div class="card-body">
                    <h5 class="card-title">{{ $product->title }}</h5>
                </div>
                <div class="card-footer text-center">
                    ${{ $product->price }}
                    <button class="btn btn-primary btn-add-to-cart" data-id="{{ $product->id }}">加入購物車</button>
                </div>
            </div>
        @empty
            <div class="card mb-4">
                <div class="card-body">
                    <h1 class="card-title">Your shopping cart is empty.</h1>
                </div>
            </div>
        @endforelse
    </div>
    <input type="hidden" name="amount" value="1">
@endsection

@section('scriptsAfterJs')
    <script>
        $(document).ready(function() {
            @include('product.add_to_cart')
        });
    </script>
@endsection
