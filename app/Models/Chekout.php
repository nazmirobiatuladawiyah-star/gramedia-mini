<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use illuminate\Database\Eloquent\attributes\Fillable;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[Fillable(['user_id', 'payment_mothod', 'total_price', 'status', 'total_book', 'total_book_price'])]
//kalo ada _id berrati posisi ke 2 
class Chekout extends Model
{
    public function checkoutBooks() : HasMany
    {
        return $this->hasMany(CheckoutBook::class);
    }

    public function user() : BelongsTo
    {
        return $this->belongTo(User::class);
    }
}
