<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Fillable(['chechout_id', 'book_id', 'total_book'])]

class CheckoutBook extends Model
{
    public function Chekout() : BelongsTo
    {
        return $this->belongsTo (Chekout::class);
    }

    public function book(): BelongsTo
    {
        return $this->belongsTo(Book::class);
    }
}
