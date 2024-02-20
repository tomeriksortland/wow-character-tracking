<?php
namespace App\Services;


use App\Models\User;
use Illuminate\Support\Facades\Http;
use Laravel\Socialite\Facades\Socialite;

class BattleNetService {

    public function getUser() : User
    {
        $battleNetUser = Socialite::driver('battlenet')->user();

        $user = User::where('battlenet_id', $battleNetUser->getId())->where('nickname', $battleNetUser->getNickname())->first();

        if(! $user) {
            $user = User::create([
                'battlenet_id' => $battleNetUser->getId(),
                'nickname' => $battleNetUser->getNickname(),
                'access_token' => $battleNetUser->token
            ]);
            }

        if($user->access_token !== $battleNetUser->token) {
            $user->update([
                'access_token' => $battleNetUser->token
            ]);
        }

        return $user;
    }

    public function getCharacters(User $user)
    {
        $response = Http::get('https://eu.api.blizzard.com/profile/user/wow',
            [
                'namespace' => 'profile-eu',
                'locale' => 'en_eu',
                'access_token' => $user->access_token
            ]);

        return json_decode($response->body());
    }



}

