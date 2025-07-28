<?php

namespace App\Models;

use App\Models\Rak;
use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    protected $fillable = ['judul', 'rak_id'];

    public function rak()
{
    return $this->belongsTo(Rak::class);
}
}
