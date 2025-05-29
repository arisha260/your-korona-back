<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'client_name',
        'client_tel',
        'client_email',
        'client_city',
        'client_address',
        'client_index',
        'client_comment',
        'client_token',
        'delivery_method',
        'payment_method',
        'status',
        'total_quantity',
        'subtotal_price',
        'total_price',
    ];

    public function getDeliveryMethodLabelAttribute(): string
    {
        return [
            'pickup' => 'Самовывоз',
            'cdek' => 'СДЭК',
            'yandex' => 'Яндекс',
            'russian_post' => 'Почта России',
            'courier' => 'Курьер',
        ][$this->delivery_method] ?? $this->delivery_method;
    }

    public function getPaymentMethodLabelAttribute(): string
    {
        return [
            'sbp' => 'СБП',
            'card' => 'Картой',
            'cash' => 'Оплата при получении',
        ][$this->payment_method] ?? $this->payment_method;
    }

    public function getStatusLabelAttribute(): string
    {
        return [
            'waiting' => 'Ожидает обработки',
            'processing' => 'В обработке',
            'shipped' => 'Отправлен',
            'delivered' => 'Доставлен',
            'cancelled' => 'Отменён',
        ][$this->status] ?? $this->status;
    }

    public function products()
    {
        return $this->belongsToMany(Product::class)
            ->withPivot('quantity')
            ->withTimestamps();
    }

    public function getCreatedLabelAttribute()
    {
        return $this->created_at->format('d.m.Y (H:i)');
    }

    public function getUpdatedLabelAttribute()
    {
        return $this->updated_at->format('d.m.Y (H:i)');
    }

}
