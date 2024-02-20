<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'battlenet_id',
        'nickname',
        'access_token',
    ];

    public function myCharacters()
    {
        return $this->hasMany(Character::class);
    }

    public function characterSearches()
    {
        return $this->hasMany(CharacterSearch::class);
    }


    public function userJob()
    {
        return $this->belongsTo(UserJob::class)->first();
    }
}
