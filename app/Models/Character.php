<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Character extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function users()
    {
        return $this->belongsToMany(User::class);
    }

    public function characterMythicPlusScore() : HasOne
    {
        return $this->hasOne(CharacterMythicPlusScore::class);
    }

    public function characterMythicPlusHighestLevelRuns() : HasMany
    {
        return $this->hasMany(CharacterMythicPlusHighestLevelRun::class);
    }
}
