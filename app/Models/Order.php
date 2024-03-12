<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Order extends Model
{
    protected $fillable = [
        'order_id', 'user_id', 'address', 'total', 'closed'
    ];

    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }

    public function items()
    {
        return $this->hasMany('App\Models\OrderItem');
    }

    public function getOrderId()
    {
        return time().str_replace("-", "",substr(Str::uuid()->toString(), 0,10));
    }
}
