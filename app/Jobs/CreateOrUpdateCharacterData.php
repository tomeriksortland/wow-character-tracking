<?php

namespace App\Jobs;

use App\Models\User;
use App\Services\BattleNetService;
use App\Services\RaiderIOService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Http\Client\Pool;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Http;

class CreateOrUpdateCharacterData implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * The number of times the job may be attempted.
     *
     * @var int
     */
    public int $tries = 5;

    public function __construct(private readonly User $user)
    {
    }


    /**
     * Execute the job.
     */
    public function handle(BattleNetService $battleNetService, RaiderIOService $raiderIOService): void
    {
        $characters = $battleNetService->getCharacters($this->user);

        $charactersArray = [];

        foreach($characters->wow_accounts[0]->characters as $character) {
            if($character->level !== 70) {
                continue;
            }

            $charactersArray[] = ['region' => 'EU', 'slug' => $character->realm->slug, 'name' => $character->name];
        }

            $characterData = $raiderIOService->fetchCharacterData($charactersArray);
            $raiderIOService->storeOrUpdateCharacterData($this->user, $characterData);
    }
}
