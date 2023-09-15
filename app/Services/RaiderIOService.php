<?php

namespace App\Services;

use App\Models\Character;
use App\Models\CharacterSearch;
use App\Models\User;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Client\Pool;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;
use Inertia\Inertia;

class RaiderIOService
{

    public function fetchCharacterData(string $region, string $realm, string $characterName) : \stdClass|RedirectResponse
    {
        try {
            $response = Http::get('https://raider.io/api/v1/characters/profile', [
                'region' => $region,
                'realm' => $realm,
                'name' => $characterName,
                'fields' => 'mythic_plus_scores_by_season:current,mythic_plus_recent_runs,mythic_plus_highest_level_runs'
            ]);

        } catch (Exception $exception) {
            DB::insert(
                "INSERT INTO api_logs (user_id, error_code, error_message) VALUES (?, ?, ?)",
                [Auth::id(), $exception->getCode(), $exception->getMessage()]
            );
        }

        if (isset($response) && $response->failed()) {
            return to_route('character-search.index', ['error' => $response->body()]);
        }

        return json_decode($response->body());

    }

    public function storeOrUpdateCharacterDataWhenLoggingIn(User $user, mixed $data) : Character
    {

        $character = Character::updateOrCreate(
            [
                'name' => $data->name,
                'realm' => $data->realm,
                'region' => $data->region
            ],
            [
                'user_id' => $user->id,
                'race' => $data->race,
                'class' => $data->class,
                'spec' => $data->active_spec_name,
                'gender' => $data->gender,
                'faction' => $data->faction,
                'thumbnail' => $data->thumbnail_url,
                'realm' => $data->realm,
                'region' => $data->region,
                'profile_url' => $data->profile_url
            ]);

        $character->touch();

        $character->mythicPlusScore()->updateOrCreate(
            [
                'character_id' => $character->id,
                'overall' => $data->mythic_plus_scores_by_season[0]->segments->all->score
            ],
            [
                'character_id' => $character->id,
                'overall' => $data->mythic_plus_scores_by_season[0]->segments->all->score,
                'overall_color' => $data->mythic_plus_scores_by_season[0]->segments->all->color,
                'tank' => $data->mythic_plus_scores_by_season[0]->segments->tank->score,
                'tank_color' => $data->mythic_plus_scores_by_season[0]->segments->tank->color,
                'healer' => $data->mythic_plus_scores_by_season[0]->segments->healer->score,
                'healer_color' => $data->mythic_plus_scores_by_season[0]->segments->healer->color,
                'dps' => $data->mythic_plus_scores_by_season[0]->segments->dps->score,
                'dps_color' => $data->mythic_plus_scores_by_season[0]->segments->dps->color,
            ]);

        /*$i = 0;

        foreach($data->mythic_plus_recent_runs as $recentRun)
        {
            $character->mythicPlusRuns()->create([
                [
                    'dungeon' => $recentRun->dungeon,
                    'key_level' => $recentRun->mythic_level,
                    'completed_at' => $recentRun->completed_at,

                ],
                [

                ]
            ]);
        }*/

        $i = 0;
        foreach ($data->mythic_plus_highest_level_runs as $run)
        {
            if ($i === 5) break;

            $character->mythicPlusHighestLevelRuns()->updateOrCreate(
                [
                    'character_id' => $character->id,
                    'dungeon' => $run->dungeon,
                    'key_level' => $run->mythic_level,
                    'affix_one' => $run->affixes[0]->name,
                    'affix_two' => $run->affixes[1]->name,
                    'affix_three' => $run->affixes[2]->name,
                    'completed_at' => $run->completed_at
                ],
                [
                    'character_id' => $character->id,
                    'dungeon' => $run->dungeon,
                    'key_level' => $run->mythic_level,
                    'completion_time' => $run->clear_time_ms,
                    'dungeon_total_time' => $run->par_time_ms,
                    'affix_one' => $run->affixes[0]->name,
                    'affix_one_icon' => $run->affixes[0]->icon,
                    'affix_two' => $run->affixes[1]->name,
                    'affix_two_icon' => $run->affixes[1]->icon,
                    'affix_three' => $run->affixes[2]->name,
                    'affix_three_icon' => $run->affixes[2]->icon,
                    'seasonal_affix' => $run->affixes[3]->name ?? '',
                    'seasonal_affix_icon' => $run->affixes[3]->icon ?? '',
                    'run_id' => preg_match('/\/season-df-2\/([^\/-]+)/', $run->url, $matches) ? $matches[1] : null,
                    'run_url' => $run->url,
                    'completed_at' => Carbon::parse($run->completed_at)
                ]);

            $i++;
        }

        return $character;
    }

    public function storeOrUpdateCharacterDataWhenSearching(User $user, mixed $data, bool $search = false)
    {
        $alreadyExistingCharacter = Character::where('region', $data->region)->where('realm', $data->realm)->where('name', $data->name)->first();

        $character = Character::updateOrCreate(
            [
                'name' => $data->name,
                'realm' => $data->realm,
                'region' => $data->region
            ],
            [
                'user_id' => $alreadyExistingCharacter ? $alreadyExistingCharacter->user_id : 0,
                'race' => $data->race,
                'class' => $data->class,
                'spec' => $data->active_spec_name,
                'gender' => $data->gender,
                'faction' => $data->faction,
                'thumbnail' => $data->thumbnail_url,
                'realm' => $data->realm,
                'region' => $data->region,
                'profile_url' => $data->profile_url
            ]);

        $character->mythicPlusScore()->updateOrCreate(
            [
                'character_id' => $character->id,
                'overall' => $data->mythic_plus_scores_by_season[0]->segments->all->score
            ],
            [
                'character_id' => $character->id,
                'overall' => $data->mythic_plus_scores_by_season[0]->segments->all->score,
                'overall_color' => $data->mythic_plus_scores_by_season[0]->segments->all->color,
                'tank' => $data->mythic_plus_scores_by_season[0]->segments->tank->score,
                'tank_color' => $data->mythic_plus_scores_by_season[0]->segments->tank->color,
                'healer' => $data->mythic_plus_scores_by_season[0]->segments->healer->score,
                'healer_color' => $data->mythic_plus_scores_by_season[0]->segments->healer->color,
                'dps' => $data->mythic_plus_scores_by_season[0]->segments->dps->score,
                'dps_color' => $data->mythic_plus_scores_by_season[0]->segments->dps->color,
            ]);

        /*$i = 0;

        foreach($data->mythic_plus_recent_runs as $recentRun)
        {
            $character->mythicPlusRuns()->create([
                [
                    'dungeon' => $recentRun->dungeon,
                    'key_level' => $recentRun->mythic_level,
                    'completed_at' => $recentRun->completed_at,

                ],
                [

                ]
            ]);
        }*/

        $i = 0;
        foreach ($data->mythic_plus_highest_level_runs as $run)
        {
            if ($i === 5) break;

            $character->mythicPlusHighestLevelRuns()->updateOrCreate(
                [
                    'character_id' => $character->id,
                    'dungeon' => $run->dungeon,
                    'key_level' => $run->mythic_level,
                    'affix_one' => $run->affixes[0]->name,
                    'affix_two' => $run->affixes[1]->name,
                    'affix_three' => $run->affixes[2]->name,
                    'completed_at' => $run->completed_at
                ],
                [
                    'character_id' => $character->id,
                    'dungeon' => $run->dungeon,
                    'key_level' => $run->mythic_level,
                    'completion_time' => $run->clear_time_ms,
                    'dungeon_total_time' => $run->par_time_ms,
                    'affix_one' => $run->affixes[0]->name,
                    'affix_one_icon' => $run->affixes[0]->icon,
                    'affix_two' => $run->affixes[1]->name,
                    'affix_two_icon' => $run->affixes[1]->icon,
                    'affix_three' => $run->affixes[2]->name,
                    'affix_three_icon' => $run->affixes[2]->icon,
                    'seasonal_affix' => $run->affixes[3]->name ?? '',
                    'seasonal_affix_icon' => $run->affixes[3]->icon ?? '',
                    'run_id' => preg_match('/\/season-df-2\/([^\/-]+)/', $run->url, $matches) ? $matches[1] : null,
                    'run_url' => $run->url,
                    'completed_at' => Carbon::parse($run->completed_at)
                ]);

            $i++;
        }

        if($search) {
            CharacterSearch::updateOrCreate(
                [
                    'user_id' => $user->id,
                    'character_id' => $character->id
                ],
                [
                    'user_id' => $user->id,
                    'character_id' => $character->id,
                    'searched_at' => Carbon::now()
                ]
            );
        }

        return $character;

    }


}

