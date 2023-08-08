<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Library extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $hidden = [
        'created_at',
        'updated_at',
        'grade_id',
        'class_room_id',
    ];
    public function file()
    {
        return $this->morphOne(LocalUrl::class, 'urlable');
    }

    public function grade()
    {
        return $this->belongsTo(Grade::class,'grade_id');
    }

    public function classRoom()
    {
        return $this->belongsTo(ClassRoom::class,'class_room_id');
    }
}
