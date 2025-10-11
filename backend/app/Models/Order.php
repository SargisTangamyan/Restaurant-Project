<?php

namespace App\Models;

use App\Enums\OrderStatus;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Order extends Model
{
    protected $fillable = [
        'user_id',
        'total_price',
        'status',
        'payment_method',
    ];

    protected $casts = [
        'status' => OrderStatus::class,
    ];

    public function items(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function canBeCancelled(): bool
    {
        return in_array($this->status, [
            OrderStatus::Pending->value,
            OrderStatus::Confirmed->value,
            OrderStatus::Preparing->value,
        ]);
    }
}
