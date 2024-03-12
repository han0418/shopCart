<?php

namespace App\Http\Controllers;

use App\Exceptions\CustomException;
use App\Models\Order;
use App\Models\User;
use App\Models\OrderItem;
use App\Models\Product;
use App\Services\EcPayService;
use Illuminate\Http\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $user = $request->user();
        return view('order.index', compact('user'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $user = $request->user();
        $order = new Order;
        DB::transaction(function () use (&$order, $user, $request) {
            $order->address = $request->address;
            $order->total = 0;
            $order->closed = 0;
            $order->user_id = $user->id;
            $order->order_id = $order->getOrderId();
            $order->save();

            $total = 0;
            foreach ($request->amount as $product_id => $amount) {
                $product = Product::find($product_id);
                $item = new OrderItem;
                $item->order_id = $order->id;
                $item->product_id = $product_id;
                $item->amount = $amount;
                $item->price = $product->price;
                $item->save();
                $total += $product->price * $amount;
            }

            $order->total = $total;
            $order->update();

            $user->carts()->delete();
        });

        $ecPay = resolve(EcPayService::class);
        $htmlForm = $ecPay->createPaymentForm($order);
        return new Response($htmlForm);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function show(Order $order)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function edit(Order $order)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function update($orderId)
    {
        $order = Order::where('order_id', $orderId)->first();
        $order->closed = true;
        $order->save();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function destroy(Order $order)
    {
        //
    }

    public function callback(Request $request)
    {
        $status = $request['RtnCode'];
        $orderId = $request['MerchantTradeNo'];
        if ($status){
            $this->update($orderId);
        }else{
            logger('Order: ' .$orderId. ' Payment Failed!');
        }
    }

    public function redirectFromECpay()
    {
        return redirect('/product');
    }
}
