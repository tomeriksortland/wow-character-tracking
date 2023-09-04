<?php

namespace App\Http\Controllers;

use App\Http\Requests\CharacterSearchRequest;
use App\Models\Character;
use App\Models\User;
use App\Services\CharacterSearchService;
use Inertia\Inertia;

class CharacterSearchController extends Controller
{

    public function index() : \Inertia\Response
    {
        return Inertia::render('characterSearch/Index', [
            'lastSixCharacterSearches' => User::findOrFail(auth()->id())
                ->characterSearches()
                ->with('characterMythicPlusScore')
                ->orderByDesc('updated_at')
                ->take(6)
                ->get()
        ]);
    }

    public function show(Character $character) : \Inertia\Response
    {
        return Inertia::render('characterSearch/Show', [
            'character' => Character::with(['characterMythicPlusScore', 'characterMythicPlusHighestLevelRuns'] )->find($character->id)
        ]);
    }

    public function store(CharacterSearchRequest $request, CharacterSearchService $searchService)
    {
        $apiData = $searchService->fetchApiData($request->region, $request->realm, $request->characterName);
        $character = Character::where('name', $request->characterName)->where('realm', $request->realm)->where('region', $request->region)->first();
        if($character) {
            $character = $searchService->updateCharacterData($apiData, $character);
        } else {
            $character = $searchService->storeCharacterData($apiData);
        }

        return to_route('character-search.show', $character);

    }
}
