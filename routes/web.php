<?php

use App\Http\Controllers\CharacterController;
use App\Http\Controllers\ContestController;
use App\Http\Controllers\PlaceController;
use App\Http\Controllers\ProfileController;
use App\Models\Character;
use App\Models\Contest;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    $appName = "ELTE Laravel Game";
    return view('welcome',['name'=>$appName,'contests' => Contest::count(),'characters'=>Character::count()]);
})->name('home');



Route::middleware('auth')->group(function () {
    //Characters
    Route::get('/characters/create/', [CharacterController::class, 'create'])->name('characters.create');
    Route::get('/characters',[CharacterController::class, 'index'])->middleware(['auth', 'verified'])->name('characters');
    Route::delete('/characters/{character}/delete', [CharacterController::class, 'destroy'])->name('characters.delete');
    Route::get('/characters/{character}/edit', [CharacterController::class, 'edit'])->name('characters.edit');
    Route::get('/characters/{character}', [CharacterController::class, 'show'])->name('characters.show');
    
    Route::post('/characters/store', [CharacterController::class, 'store'])->name('characters.store');
    Route::patch('/characters/{character}/update', [CharacterController::class, 'update'])->name('characters.update');
    //Contests
    Route::get('/contests/{contest}', [ContestController::class, 'show'])->name('contests.show');
    Route::get('/contests/{contest}/{attackType}', [ContestController::class, 'update'])->name('contests.attack');
    Route::post('/characters/{character}/newContest', [ContestController::class, 'store'])->name('contests.new');   


    //Places
    Route::get('/places',[PlaceController::class, 'index'])->name('places');
    Route::get('/places/{place}/edit', [PlaceController::class, 'edit'])->name('places.edit');
    Route::patch('/places/{place}/update', [PlaceController::class, 'update'])->name('places.update');
    Route::get('/places/create/', [PlaceController::class, 'create'])->name('places.create');
    Route::post('/places/store', [PlaceController::class, 'store'])->name('places.store');
    Route::delete('/places/{place}', [PlaceController::class, 'destroy'])->name('places.delete');



    
});


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
