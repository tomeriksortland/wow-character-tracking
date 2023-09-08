<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class DashboardController extends Controller
{
    public function index()
    {
        return Inertia::render('Dashboard', [
            'myCharacters' => User::findOrFail(Auth::id())
                ->myCharacters()
                ->with(['characterMythicPlusScore'])
                ->take(8)
                ->get()
        ]);
    }
}
