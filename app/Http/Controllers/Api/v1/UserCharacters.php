<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserCharacters extends Controller
{
    public function index(User $user)
    {
        return response()->json(User::findOrFail($user->id)
            ->myCharacters()
            ->with(['characterMythicPlusScore'])
            ->take(8)
            ->get());
    }
}
