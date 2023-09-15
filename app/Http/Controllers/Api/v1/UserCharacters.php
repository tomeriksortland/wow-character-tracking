<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Models\Character;
use App\Models\User;
use App\Models\UserJob;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserCharacters extends Controller
{
    public function index(User $user)
    {
        $characters = [];
        $createOrUpdateCharactersJob = UserJob::where('user_id', $user->id)->latest()->first();

        if($createOrUpdateCharactersJob->status === 'completed')
        {
            $characters = Character::query()
                ->join('mythic_plus_scores', 'characters.id', '=', 'mythic_plus_scores.character_id')
                ->orderByDesc('Overall')
                ->take(8)
                ->get();
        }



        return response()->json([
            'myCharacters' => $characters,
            'jobStatus' => $createOrUpdateCharactersJob->status
        ]);
    }
}
