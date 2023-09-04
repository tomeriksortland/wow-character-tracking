<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Services\CharacterSearchService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Laravel\Socialite\Facades\Socialite;

class LoginWithBattleNetController extends Controller
{
    public function redirect()
    {
        return Socialite::driver('battlenet')->scopes(['wow.profile'])->redirect();
    }

    public function callback(CharacterSearchService $searchService)
    {
        $battleNetUser = Socialite::driver('battlenet')->user();

        $user = User::where('battlenet_id', $battleNetUser->getId())->where('nickname', $battleNetUser->getNickname())->first();

        if(! $user) {
            $user = User::create([
                'battlenet_id' => $battleNetUser->getId(),
                'nickname' => $battleNetUser->getNickname(),
                'access_token' => $battleNetUser->token
            ]);

            $response = Http::get('https://eu.api.blizzard.com/profile/user/wow',
                [
                    'namespace' => 'profile-eu',
                    'locale' => 'en_eu',
                    'access_token' => $user->access_token
                ]);

            $data = json_decode($response->body());

            foreach($data->wow_accounts[0]->characters as $character) {
                if($character->level !== 70) {
                    continue;
                }

                $raiderIOCharacterData = $searchService->fetchApiData('eu', $character->realm->slug, $character->name);
                $searchService->storeCharacterData($raiderIOCharacterData, $user);
            }

        }

        Auth::login($user);

        return redirect(route('dashboard.index'));
    }
}
