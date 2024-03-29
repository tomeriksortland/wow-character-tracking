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

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function characterSearches()
    {
        return $this->hasMany(CharacterSearch::class);
    }

    public function mythicPlusScore() : HasOne
    {
        return $this->hasOne(MythicPlusScore::class);
    }

    public function mythicPlusPreviousScore() : HasOne
    {
        return $this->hasOne(MythicPlusPreviousScore::class);
    }

    public function mythicPlusHighestLevelRuns() : HasMany
    {
        return $this->hasMany(MythicPlusHighestLevelRun::class);
    }
}
