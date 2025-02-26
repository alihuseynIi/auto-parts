<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    protected $fillable = [
        'order_id',
        'product_id',
        'product_name',
        'product_price',
        'quantity',
        'total_price',
    ];

    /**
     * Sifarişə (OrderNotification) əlaqə.
     */
    public function order()
    {
        return $this->belongsTo(Order::class, 'order_id');
    }

    /**
     * Məhsula (Product) əlaqə.
     */
    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }
}
