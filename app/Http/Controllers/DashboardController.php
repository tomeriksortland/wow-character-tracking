<?php

namespace App\Http\Controllers;

use App\Models\Character;
use App\Models\User;
use App\Models\UserJob;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class DashboardController extends Controller
{
    public function index()
    {
        return Inertia::render('Dashboard', [
            'myCharacters' => Character::query()
                ->where('characters.user_id', Auth::id())
                ->join('mythic_plus_scores', 'characters.id', '=', 'mythic_plus_scores.character_id')
                ->take(8)
                ->orderByDesc('overall')
                ->get(),
            'allCharactersFetched' => UserJob::where('user_id', Auth()->id())->first()->status
        ]);
    }
}
