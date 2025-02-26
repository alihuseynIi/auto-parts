<?php

namespace App\Models;

use App\Notifications\OrderNotification;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Notification;

class Order extends Model
{
    use HasFactory;

    /**
     * @return void
     */
    protected static function boot(): void
    {
        parent::boot();

        static::created(function ($order) {
            $adminUsers = User::query()->where('is_admin', true)->get();
            Notification::send($adminUsers, new OrderNotification($order->id));
        });
    }

    /**
     * @var string[]
     */
    protected $fillable = [
        'user_id',
        'order_number',
        'total_price',
        'status',
    ];

    /**
     * @return BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * @return HasMany
     */
    public function items(): HasMany
    {
        return $this->hasMany(OrderItem::class, "order_id");
    }
}
