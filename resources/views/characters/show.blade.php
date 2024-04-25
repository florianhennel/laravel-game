@extends('dashboard')
@section('content')
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 flex flex-col gap-2">
        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg mb-6">
            <div class="p-6 text-gray-900 dark:text-gray-100 flex justify-between">
                <div style="width: 300px; ">
                    name: <span
                        style="font-family:'Pacifico', cursive; font-weight:900;font-style:italic;">{{ $character->name }}</span>
                </div>
                <div style="width: 200px; user-select:none;">
                    <i class="fas fa-shield-alt"></i>
                    {{ $character->defence }}
                </div>
                <div style="width: 200px; user-select:none;">
                    <i class="fas fa-dumbbell"></i>
                    {{ $character->strength }}
                </div>
                <div style="width: 200px; user-select:none;">
                    <i class="fas fa-bullseye"></i>
                    {{ $character->accuracy }}
                </div>
                <div style="width: 200px; user-select:none;">
                    <i class="fas fa-magic"></i>
                    {{ $character->magic }}
                </div>
            </div>

        </div>
        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg w-fit">
            <div class="p-6 text-gray-900 dark:text-gray-100">Contests:</div></div>
        @foreach ($contests as $c)
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg w-2/3 p-6 text-gray-900 dark:text-gray-100 flex justify-between items-center">
                    <div style="">
                        place: <span
                            style="font-family:'Pacifico', cursive; font-weight:900;font-style:italic;">{{ $c->place->name }}</span>
                    </div>
                    <div class="flex items-center gap-4 justify-center w-2/3">
                        <div style=" display:flex; user-select:none; width:25%; justify-content: start; gap:1rem;">
                            @if (($c->win === 1 && $c->characters[0]->enemy === 0) || ($c->win === 0 && $c->characters[0]->enemy ===1))
                            <i class="fas fa-trophy"></i>
                            @elseif (($c->win === 1 && $c->characters[0]->enemy === 1) || ($c->win === 0 && $c->characters[0]->enemy ===0))
                                <i class="fas fa-skull"></i>
                            @else
                            <i class="fas fa-helmet-battle"></i>
                            @endif
                            {{ $c->characters[0]->name }}
                        </div>
                        <div> : </div>
                        <div style="display:flex; user-select:none; width:25%; justify-content: end; gap:1rem;">
                            {{ $c->characters[1]->name }}
                            @if (($c->win === 1 && $c->characters[1]->enemy === 0) || ($c->win === 0 && $c->characters[1]->enemy ===1))
                            <i class="fas fa-trophy"></i>  
                            @elseif (($c->win === 1 && $c->characters[1]->enemy === 1) || ($c->win === 0 && $c->characters[1]->enemy ===0))
                                <i class="fas fa-skull"></i>
                            @else
                            <i class="fas fa-helmet-battle"></i>
                            @endif
                            
                        </div>
                    </div>
                    
                    <a href="{{ route('contests.show', ['contest' => $c]) }}"><i class="fas fa-arrow-right"></i></a>
            </div>
        @endforeach
    </div>
    </div>
@endsection

@section('title')
    Characters -> {{ $character->name }}
@endsection
@section('contentt')
<div class="flex flex-col text-white w-1/2">
    <div class="flex items-center justify-between w-full">
        <div class="w-1/4">aaa</div>
        <div class="mx-2">:</div>
        <div class="w-1/4">aaaaaaaaaaaaaaaaaaaaaa</div>
    </div>
    <div class="flex items-center justify-between w-full">
        <div class="w-1/4">aaaaaaaaaaaaaaa</div>
        <div class="mx-2">:</div>
        <div class="w-1/4">aa</div>
    </div>
    <div class="flex items-center justify-between w-full">
        <div class="w-1/4">aaaaaa</div>
        <div class="mx-2">:</div>
        <div class="w-1/4">aaaaaaa</div>
    </div>
</div>
@endsection