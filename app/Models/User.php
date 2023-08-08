<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Tymon\JWTAuth\Contracts\JWTSubject;

class User extends Authenticatable implements JWTSubject
{
    use HasFactory, Notifiable;

    protected $guarded = [];

    protected $hidden = [
        'password',
        'remember_token',
        'created_at',
        'updated_at',
        'grade_id',
        'class_room_id',
        'section_id',
        'gender_id'
    ];

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims()
    {
        return [];
    }

    public function grade()
    {
        return $this->belongsTo(Grade::class,'grade_id');
    }

    public function classRoom()
    {
        return $this->belongsTo(ClassRoom::class,'class_room_id');
    }

    public function section()
    {
        return $this->belongsTo(Section::class,'section_id');
    }

    public function gender()
    {
        return $this->belongsTo(Gender::class,'gender_id');
    }
}
