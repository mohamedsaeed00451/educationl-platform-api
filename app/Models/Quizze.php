<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Quizze extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $hidden = [
        'created_at',
        'updated_at',
        'grade_id',
        'class_room_id',
    ];
    public function grade()
    {
        return $this->belongsTo(Grade::class,'grade_id');
    }

    public function classRoom()
    {
        return $this->belongsTo(ClassRoom::class,'class_room_id');
    }

    public function questions()
    {
        return $this->hasMany(Question::class,'quizze_id');
    }
}
