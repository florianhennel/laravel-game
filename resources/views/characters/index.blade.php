@extends('dashboard')
@section('content')
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 flex flex-col gap-2">
        @foreach ($characters as $c)
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100 flex justify-between">   
                    <div style="width: 300px; ">
                        name: <span style="font-family:'Pacifico', cursive; font-weight:900;font-style:italic;">{{ $c->name }}</span>  
                    </div>
                    <div style="width: 200px; user-select:none;">
                        <i class="fas fa-shield-alt"></i>
                        {{ $c->defence }}
                    </div>
                    <div style="width: 200px; user-select:none;">
                        <i class="fas fa-dumbbell"></i>
                         {{ $c->strength }}
                    </div>
                    <div style="width: 200px; user-select:none;">
                        <i class="fas fa-bullseye"></i>
                             {{ $c->accuracy }}
                        </div>
                    <div style="width: 200px; user-select:none;">
                        <i class="fas fa-magic"></i>
                         {{ $c->magic }}
                    </div>
                    <a href="{{ route('characters.show', ['character' => $c]) }}"><i class="fas fa-arrow-right"></i></a>
                </div>
                
            </div>
        @endforeach
    </div>
@endsection
@section('title')
    Characters
@endsection
