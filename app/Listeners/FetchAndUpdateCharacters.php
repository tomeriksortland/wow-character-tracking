<?php

namespace App\Listeners;

use App\Events\UpdateCharacters;
use App\Services\BattleNetService;
use App\Services\RaiderIOService;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class FetchAndUpdateCharacters
{
    /**
     * Create the event listener.
     */

    private BattleNetService $battleNetService;
    private RaiderIOService $raiderIOService;

    public function __construct(BattleNetService $battleNetService, RaiderIOService $raiderIOService)
    {
        $this->battleNetService = $battleNetService;
        $this->raiderIOService = $raiderIOService;
    }

    /**
     * Handle the event.
     */
    public function handle(UpdateCharacters $event): void
    {
        $event->characterUpdate->update([
            'status' => 'started'
        ]);

        $characters = $this->battleNetService->getCharacters($event->user);


        foreach ($characters->wow_accounts[0]->characters as $character) {
            if ($character->level !== 70) {
                continue;
            }

            $characterData = $this->raiderIOService->fetchCharacterData('EU', $character->realm->slug, $character->name);
            $this->raiderIOService->storeOrUpdateCharacterDataWhenLoggingIn($event->user, $characterData);
        }

        $event->characterUpdate->update([
            'status' => 'completed'
        ]);
    }
}
