<?php

use App\Http\Controllers\Auth\LoginWithBattleNetController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CharacterSearchController;
use App\Models\User;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return Inertia::render('Auth/Login');
});

Route::get('login/redirect', [LoginWithBattleNetController::class, 'redirect']);
Route::get('auth/callback', [LoginWithBattleNetController::class, 'callback'])->name('login-with-battle-net.callback');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard.index');
    Route::get('/searchForCharacter', [CharacterSearchController::class, 'index'])->name('character-search.index');
    Route::get('/searchForCharacter/{character}', [CharacterSearchController::class, 'show'])->name('character-search.show');
    Route::post('/searchForCharacter', [CharacterSearchController::class, 'store'])->name('character-search.store');
});

require __DIR__.'/auth.php';
