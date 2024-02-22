@extends('layouts.app')
@section('content')
    <h1>My Order</h1>
    @forelse($user->orders as $order)
        <div class="card @if($order->closed) border-secondary @else border-info @endif mb-3">
            <div class="card-header text-white @if($order->closed) bg-secondary @else bg-info @endif">
                Order Date：{{ $order->created_at}}
                <span class="float-right">
                    Order Status：
                    @if($order->closed)
                        Finished
                    @else
                        Processing
                    @endif
                </span>
            </div>
            <div class="card-body">
                <table class="table table-striped">
                    <tr>
                        <th colspan=2>Product Name</th>
                        <th nowrap class="text-right">Price</th>
                        <th nowrap class="text-center">Quantity</th>
                        <th nowrap class="text-right">Amount</th>
                    </tr>
                    @foreach($order->items as $item)
                        <tr>
                            <td>
                                <a target="_blank" href="/product/{{ $item->product_id }}">
                                    <img src="{{ $item->product->image_url }}" class="img-thumbnail" style="width: 120px;">
                                </a>
                            </td>
                            <td>
                                <a target="_blank" href="/product/{{ $item->product_id }}">
                                    <h5>{{ $item->product->title }}</h5>
                                </a>
                                @if(!$item->product->on_sale)
                                    <div class="warning">This item has been discontinued.</div>
                                @endif
                            </td>
                            <td class="text-right">
                                {{ $item->product->price }} dollars
                            </td>
                            <td class="text-center">
                                {{ $item->amount }}
                            </td>
                            <td class="text-right">
                                {{ $item->product->price * $item->amount }} dollars
                            </td>
                        </tr>
                    @endforeach
                    <tr>
                        <th colspan=5 class="text-right">
                            Total amount :{{ $order->total }} dollars
                        </th>
                    </tr>
                </table>
            </div>
        </div>
    @empty
        <div class="alert alert-info">
            <h2>No order</h2>
        </div>
    @endforelse

@endsection
