@extends('dashboard')
@section('content')
    <div class="flex flex-wrap gap-8 p-2 justify-center">
        @foreach ($places as $p)
            <div
                class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg text-gray-900 dark:text-gray-100 flex flex-col w-3/12 p-2 items-center max-h-1/4 relative">
                <img class="" src="{{ $p->image }}" alt="place_{{ $p->id }}">
                <div class=" flex gap-1 items-center">
                    <span
                        style="font-family:'Pacifico', cursive; font-weight:900;font-style:italic;">{{ $p->name }}</span>
                    @can('update',$p)
                        <a href=" {{ route('places.edit', ['place' => $p]) }}" class=" flex justify-center items-center">
                            <i class="fas fa-pen"></i>
                        </a>
                    @endcan
                    @can('delete', $p)
                        <form action="{{ route('places.delete', ['place' => $p]) }}" method="POST" class="absolute right-3">
                            @csrf
                            @method('DELETE')
                            <a href="#" onclick="this.closest('form').submit()">
                                <i class="fas fa-trash"></i>
                            </a>
                        </form>
                    @endcan
                </div>

            </div>
        @endforeach
        <div
            class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg text-gray-900 dark:text-gray-100 flex flex-col p-2 w-1/4 max-h-1/4 justify-center">
            <a href=" {{ route('places.create') }}" class=" flex justify-center items-center">
                <i class="fas fa-plus"></i>
            </a>
        </div>

    </div>
@endsection
@section('title')
    Places
@endsection
