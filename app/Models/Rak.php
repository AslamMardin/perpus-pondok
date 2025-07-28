<?php

namespace App\Models;

use App\Models\Book;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Rak extends Model
{
    /** @use HasFactory<\Database\Factories\RakFactory> */
    use HasFactory;

    public $guarded = [];

    public function books()
{
    return $this->hasMany(Book::class);
}
}
