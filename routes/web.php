<?php

use App\Http\Controllers\CharacterController;
use App\Http\Controllers\ContestController;
use App\Http\Controllers\ProfileController;
use App\Models\Character;
use App\Models\Contest;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    $appName = "ELTE Laravel Game";
    return view('welcome',['name'=>$appName,'contests' => Contest::count(),'characters'=>Character::count()]);
})->name('home');



Route::middleware('auth')->group(function () {
    Route::get('/characters/{character}', [CharacterController::class, 'show'])->name('characters.show');
    Route::get('/contests/{contest}', [ContestController::class, 'show'])->name('contests.show');

    Route::get('/contests/{id}/{attackType}', [ContestController::class, 'update'])->name('contests.attack');

});

Route::get('/characters',[CharacterController::class, 'index'])->middleware(['auth', 'verified'])->name('characters');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
