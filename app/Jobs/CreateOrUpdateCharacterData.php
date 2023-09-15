<?php

namespace App\Jobs;

use App\Models\User;
use App\Models\UserJob;
use App\Services\BattleNetService;
use App\Services\RaiderIOService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class CreateOrUpdateCharacterData implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;


    public function __construct(private readonly User $user)
    {
    }


    /**
     * Execute the job.
     */
    public function handle(BattleNetService $battleNetService, RaiderIOService $raiderIOService): void
    {
        UserJob::where('user_id', $this->user->id)->latest()->first()->update([
            'status' => 'started'
        ]);

        $characters = $battleNetService->getCharacters($this->user);

        foreach ($characters->wow_accounts[0]->characters as $character) {
            if ($character->level !== 70) {
                continue;
            }

            $characterData = $raiderIOService->fetchCharacterData('EU', $character->realm->slug, $character->name);
            $raiderIOService->storeOrUpdateCharacterDataWhenLoggingIn($this->user, $characterData);
        }

        UserJob::where('user_id', $this->user->id)->latest()->first()->update([
            'status' => 'completed'
        ]);
    }
}
