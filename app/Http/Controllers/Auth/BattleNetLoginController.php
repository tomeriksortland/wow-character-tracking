<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Jobs\CreateOrUpdateCharacterData;
use App\Models\User;
use App\Services\BattleNetService;
use App\Services\CharacterSearchService;
use App\Services\RaiderIOService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Laravel\Socialite\Facades\Socialite;

class BattleNetLoginController extends Controller
{

    public function redirect()
    {
        return Socialite::driver('battlenet')->scopes(['wow.profile'])->redirect();
    }

    public function callback(BattleNetService $battleNetService, RaiderIOService $raiderIOService)
    {
        $user = $battleNetService->getUser();

        Auth::login($user);

        CreateOrUpdateCharacterData::dispatch($user);

        return redirect(route('dashboard.index'));
    }
}
