@extends('dashboard')
@section('content')
        <div class="flex flex-col items-center p-2 mb-6 mx-auto bg-white dark:bg-gray-800 rounded-lg w-1/3">
            <div class="text-3xl text-neutral-400">
                Create new character
            </div>
            <form method="POST" action="{{ route('characters.store') }}" class="mt-6 space-y-6">
                @csrf
                @method('post')
                <input type="hidden" name="user_id" value="{{ Auth::id() }}">
                <div>
                    <x-input-label for="name" :value="__('Name')" />
                    <x-text-input id="name" name="name" type="text" class="mt-1 block w-full"
                    value="{{ old('name') }}"  required autofocus autocomplete="name" />
                    <x-input-error class="mt-2" :messages="$errors->get('name')" />
                </div>
                <div>
                    <x-input-label for="defence" :value="__('Defence')" />
                    <x-number-input id="defence" name="defence" type="number" class="mt-1 block w-full"
                    value="{{ old('defence') }}"  required autofocus autocomplete="defence" />
                    <x-input-error class="mt-2" :messages="$errors->get('defence')" />
                </div>
                <div>
                    <x-input-label for="strength" :value="__('Strength')" />
                    <x-number-input id="strength" name="strength" type="number" class="mt-1 block w-full" required autofocus value="{{ old('strength') }}" autocomplete="strength" />
                    <x-input-error class="mt-2" :messages="$errors->get('strength')" />
                </div>
                <div>
                    <x-input-label for="accuracy" :value="__('Accuracy')" />
                    <x-number-input id="accuracy" name="accuracy" type="number" class="mt-1 block w-full" required autofocus value="{{ old('accuracy') }}" autocomplete="accuracy" />
                    <x-input-error class="mt-2" :messages="$errors->get('accuracy')" />
                </div>
                <div>
                    <x-input-label for="magic" :value="__('Magic')" />
                    <x-number-input id="magic" name="magic" type="number" class="mt-1 block w-full" required autofocus value="{{ old('magic') }}" autocomplete="magic" />
                    <x-input-error class="mt-2" :messages="$errors->get('magic')" />
                </div>
                <div class=" flex items-center gap-4 {{$isAdmin? " visible":"hidden"}}">
                    <x-input-label for="enemy" :value="__('enemy')" />
                    <input id="enemy" type="checkbox" class="rounded dark:bg-gray-900 border-gray-300 dark:border-gray-700 text-indigo-600 shadow-sm focus:ring-indigo-500 dark:focus:ring-indigo-600 dark:focus:ring-offset-gray-800" name="enemy" value="enemy" @checked($isAdmin)>
                </div>
                
                <x-input-error class="mt-2" :messages="$errors->get('total')" />
                <div class="flex items-center gap-4 justify-center">
                    <x-primary-button>{{ __('Save') }}</x-primary-button>
                </div>
            </form>

        </div>
@endsection
