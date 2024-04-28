@extends('dashboard')
@section('content')
        <div class="flex flex-col items-center p-2 mb-6 mx-auto bg-white dark:bg-gray-800 rounded-lg w-1/3">
            <div class="text-3xl text-neutral-400">
                Create new place
            </div>
            <form method="POST" action="{{ route('places.store') }}" enctype="multipart/form-data" class="mt-6 space-y-6">
                @csrf
                @method('POST')
                <div>
                    <x-input-label for="name" :value="__('Name')" />
                    <x-text-input id="name" name="name" type="text" class="mt-1 block w-full"
                        required autofocus autocomplete="name" />
                    <x-input-error class="mt-2" :messages="$errors->get('name')" />
                </div>
                <div class="flex gap-2 items-center">
                    <x-input-label for="image" :value="__('Image')" />
                    <input type="file" name="image" id="image" class="mt-1 block w-full" required>
                    <x-input-error class="mt-2" :messages="$errors->get('image')" />
                </div>
                <div class="flex items-center gap-4 justify-center">
                    <x-primary-button>{{ __('Save') }}</x-primary-button>
                </div>
            </form>

        </div>
@endsection
