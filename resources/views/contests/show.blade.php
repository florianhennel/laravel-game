@extends('dashboard')
@section('content')
    <div class=" h-full rounded-lg w-full bg-no-repeat bg-cover bg-center flex flex-col gap-3"
        style="background-image: url({{ $contest->place->image }});">
        <div class="flex w-full">
            <div class=" w-1/11 m-2 text-4xl text-white self-start"
                style="font-family:'Pacifico', cursive; font-weight:900;font-style:italic;">
                {{ $contest->place->name }}
            </div>
            <div
                class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6 text-gray-900 dark:text-gray-100 flex justify-between mt-2 mx-auto w-2/5">

                <div class="flex gap-2 justify-between w-full items-center">
                    <div style=" display:flex; user-select:none; justify-content: space-between; gap:6rem;">
                        <div>
                            @if (
                                ($contest->win === 1 && $contest->characters[0]->enemy === 0) ||
                                    ($contest->win === 0 && $contest->characters[0]->enemy === 1))
                                <i class="fas fa-trophy"></i>
                            @elseif (
                                ($contest->win === 1 && $contest->characters[0]->enemy === 1) ||
                                    ($contest->win === 0 && $contest->characters[0]->enemy === 0))
                                <i class="fas fa-skull"></i>
                            @else
                                <i class="fas fa-helmet-battle"></i>
                            @endif

                            {{ $contest->characters[0]->name }}
                        </div>
                        <div>
                            {{ $contest->characters[0]->enemy === 1 ? $contest->characters[0]->pivot->enemy_hp : $contest->characters[0]->pivot->hero_hp }}
                        </div>

                    </div>
                    <div> : </div>
                    <div style="display:flex; user-select:none; justify-content: space-between; gap:6rem;">
                        <div>
                            {{ $contest->characters[1]->enemy === 1 ? $contest->characters[1]->pivot->enemy_hp : $contest->characters[1]->pivot->hero_hp }}
                        </div>
                        <div>
                            {{ $contest->characters[1]->name }}



                            @if (
                                ($contest->win === 1 && $contest->characters[1]->enemy === 0) ||
                                    ($contest->win === 0 && $contest->characters[1]->enemy === 1))
                                <i class="fas fa-trophy"></i>
                            @elseif (
                                ($contest->win === 1 && $contest->characters[1]->enemy === 1) ||
                                    ($contest->win === 0 && $contest->characters[1]->enemy === 0))
                                <i class="fas fa-skull"></i>
                            @else
                                <i class="fas fa-helmet-battle"></i>
                            @endif
                        </div>

                    </div>
                </div>
            </div>
        </div>
        <div class=" flex flex-row justify-between w-full h-full p-4">
            <div
                class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6 text-gray-900 dark:text-gray-100 flex flex-col justify-between items-center w-1/12">
                <div>
                    <span
                        style="font-family:'Pacifico', cursive; font-weight:900;font-style:italic;">{{ $contest->characters[0]->name }}</span>
                </div>
                <div style="user-select:none;">
                    <i class="fas fa-shield-alt"></i>
                    {{ $contest->characters[0]->defence }}
                </div>
                <div style="user-select:none;">
                    <i class="fas fa-dumbbell"></i>
                    {{ $contest->characters[0]->strength }}
                </div>
                <div style="user-select:none;">
                    <i class="fas fa-bullseye"></i>
                    {{ $contest->characters[0]->accuracy }}
                </div>
                <div style="user-select:none;">
                    <i class="fas fa-magic"></i>
                    {{ $contest->characters[0]->magic }}
                </div>
            </div>
            <div class="flex justify-around w-1/3 items-end">
                <a class=" rounded bg-slate-400 text-white p-4" href="{{ route('contests.attack', ['id' => $contest->id, 'attackType' => 'melee']) }}">Melee</a>
                <a class="rounded bg-slate-400 text-white p-4" href="{{ route('contests.attack', ['id' => $contest->id, 'attackType' => 'ranged']) }}">Ranged</a>
                <a class="rounded bg-slate-400 text-white p-4" href="{{ route('contests.attack', ['id' => $contest->id, 'attackType' => 'special']) }}">Special</a>
            </div>
            <div
                class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6 text-gray-900 dark:text-gray-100 flex flex-col justify-between items-center w-1/12">
                <div>
                    <span
                        style="font-family:'Pacifico', cursive; font-weight:900;font-style:italic;">{{ $contest->characters[1]->name }}</span>
                </div>
                <div style="user-select:none;">
                    <i class="fas fa-shield-alt"></i>
                    {{ $contest->characters[1]->defence }}
                </div>
                <div style="user-select:none;">
                    <i class="fas fa-dumbbell"></i>
                    {{ $contest->characters[1]->strength }}
                </div>
                <div style="user-select:none;">
                    <i class="fas fa-bullseye"></i>
                    {{ $contest->characters[1]->accuracy }}
                </div>
                <div style="user-select:none;">
                    <i class="fas fa-magic"></i>
                    {{ $contest->characters[1]->magic }}
                </div>
            </div>
        </div>

    </div>
@endsection
