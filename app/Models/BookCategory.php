<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Relations\HasMany;
// use App\Models\Book;


//#a[table('book_categories')]
//properti di atas digunakan untuk menentukan nama tabel yang penamaanya tidak sesuai dengan konvensi penamaan tabel pada laravel (jamak), namun karena nama tabel book_categories sudah sesuai dengan konvensi penamaan tabel di laravel maka properti di atas tidak perlu di gunakan//
#[Fillable(['name'])]

class BookCategory extends Model {
   public function books() : HasMany {
    return $this->hasMany(Book::class);
   }
}