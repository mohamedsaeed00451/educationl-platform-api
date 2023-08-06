<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LocalUrl extends Model
{
    use HasFactory;

    public $fillable = ['filename', 'urlable_id', 'urlable_type'];

    public function urlable()
    {
        return $this->morphTo();
    }
}
