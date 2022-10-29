<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    use HasFactory;

    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    public function products()
    {
        return $this->belongsToMany(
            Product::class,
            'invoice_products',
            'invoice_id',
            'product_id')
            ->withPivot('qty')
            ->withPivot('single_price')
            ->withTimestamps();
    }
}
