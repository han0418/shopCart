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
            @if ($loop->iteration % 2 == 0)
                <div class="w-100 d-none d-sm-block d-md-none"><!-- wrap every 2 on sm--></div>
            @endif
            @if ($loop->iteration % 3 == 0)
                <div class="w-100 d-none d-md-block d-lg-none"><!-- wrap every 3 on md--></div>
            @endif
            @if ($loop->iteration % 4 == 0)
                <div class="w-100 d-none d-lg-block d-xl-none"><!-- wrap every 4 on lg--></div>
            @endif
            @if ($loop->iteration % 5 == 0)
                <div class="w-100 d-none d-xl-block"><!-- wrap every 5 on xl--></div>
            @endif
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
