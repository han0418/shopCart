
@extends('layouts.app')
@section('content')
    @php
        $total = 0;
    @endphp
    <h1>{{ $user->name }} Cart</h1>

    <table class="table table-striped">
        <tr>
            <th colspan=2>Product Name</th>
            <th nowrap class="text-right">Price</th>
            <th nowrap class="text-center">Quantity</th>
            <th nowrap class="text-right">Amount</th>
            <th>Feature</th>
        </tr>
        @forelse($user->carts as $cart)
            <tr>
                <td>
                    <a target="_blank" href="/product/{{ $cart->product_id }}">
                        <img src="{{ $cart->product->image_url }}" class="img-thumbnail" style="width: 120px;">
                    </a>
                </td>
                <td>
                    <a target="_blank" href="/product/{{ $cart->product_id }}">
                        <h5>{{ $cart->product->title }}</h5>
                    </a>
                    @if (!$cart->product->on_sale)
                        <div class="warning">This item has been discontinued.</div>
                    @endif
                </td>
                <td class="text-right">
                    <span id="price-{{ $cart->id }}">
                        {{ $cart->product->price }}
                    </span>
                </td>
                <td class="text-center">
                    @if ($cart->product->on_sale)
                        <input type="number" min="1" class="form-control text-center amount"
                            name="amount[{{ $cart->product_id }}]" value="{{ $cart->amount }}"
                            data-cartid="{{ $cart->id }}">
                    @else
                        <div class="warning">This item has been discontinued.</div>
                    @endif
                </td>
                <td class="text-right">
                    <span class="sum" id="sum-{{ $cart->id }}">
                        {{ $cart->product->price * $cart->amount }}
                    </span>
                </td>
                <td nowrap>
                    <a href="#" class="btn btn-danger btn-sm btn-del-from-cart"
                        data-id="{{ $cart->product_id }}">remove</a>
                </td>
            </tr>
            @php
                $total += $cart->product->price * $cart->amount;
            @endphp
        @empty
            <tr>
                <td>
                    <h1>Your shopping cart is empty.</h1>
                </td>
            </tr>
        @endforelse
        <tr>
            <th colspan=4 class="text-right">Total amount :</th>
            <th nowrap class="text-right">
                <span id="total">{{ $total }}</span>
            </th>
            <th>dollars</th>
        </tr>
    </table>

@endsection

@section('scriptsAfterJs')
    <script>
        $(document).ready(function() {
            $('.amount').change(function () {
                var cartid = $(this).data('cartid');
                var sum = $(this).val() * $('#price-'+cartid).text();
                $('#sum-'+cartid).text(sum);
                var total = 0;
                $('.sum').each(function() {
                    total += Number($(this).text());
                });
                $('#total').text(total);
            });
            $('.btn-del-from-cart').click(function() {
                var product_id = $(this).data('id');
                swal({
                    title: "Confirm remove of this item ?",
                    icon: "warning",
                    buttons: ['Cancel', 'Yes'],
                    dangerMode: true,
                }).then(function(willDelete) {
                    if (!willDelete) {
                        return;
                    }
                    axios.delete('/cart/' + product_id)
                        .then(function() {
                            location.reload();
                        })
                });
            });
        });
    </script>
@endsection
