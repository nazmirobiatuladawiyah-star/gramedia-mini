<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

//#[table('book_kategori)]
//pake ini kalo file migration tidak seusai stadar table memakai s

#[Fillable(['cover', 'title', 'price', 'description', 'language', 'publisher', 'writer', 'release_date', 'page_of_book', 'book_category_id'])]
//data data yang boleh di request bisa di akses, data itu patokan nya di migration

class Book extends Model {
    // nama tunggal karena book_catories berperan sebagai one dalam relasi one to many, sehingga nama fungsi memnggunakan nama tunggal (tanpa akhiran s/es/les)
    public function BookCategory(): BelongsTo
    {
        return $this->belongsTo(BookCategory::class);
    }

    public function checkoutBooks(): HasMany
    {
        return $this->hasMany (CheckoutBook::class);
    }

    public function subscriptionPackageBooks(): HasMany
    {
        return $this->hasMany(SubscriptionPackageBook::class);
    }
}

?>
