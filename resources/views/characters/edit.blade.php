@extends('dashboard')
@section('content')
    <x-modal show="true" name="edit" class="">
        <div class="flex flex-col items-center p-2">
            <div class="text-3xl text-neutral-400">
                Edit Character
            </div>
            <form method="post" action="{{ route('characters.update',['character'=>$character]) }}" class="mt-6 space-y-6">
                @csrf
                @method('patch')
                <div>
                    <x-input-label for="name" :value="__('Name')" />
                    <x-text-input id="name" name="name" type="text" class="mt-1 block w-full" :value="old('name', $character->name)"
                        required autofocus autocomplete="name" />
                    <x-input-error class="mt-2" :messages="$errors->get('name')" />
                </div>
                <div>
                    <x-input-label for="defence" :value="__('Defence')" />
                    <x-number-input id="defence" name="defence" type="number" class="mt-1 block w-full" :value="old('defence', $character->defence)"
                        required autofocus autocomplete="defence" />
                    <x-input-error class="mt-2" :messages="$errors->get('defence')" />
                </div>
                <div>
                    <x-input-label for="strength" :value="__('Strength')" />
                    <x-number-input id="strength" name="strength" type="number" class="mt-1 block w-full"
                        :value="old('strength', $character->strength)" required autofocus autocomplete="strength" />
                    <x-input-error class="mt-2" :messages="$errors->get('strength')" />
                </div>
                <div>
                    <x-input-label for="accuracy" :value="__('Accuracy')" />
                    <x-number-input id="accuracy" name="accuracy" type="number" class="mt-1 block w-full"
                        :value="old('accuracy', $character->accuracy)" required autofocus autocomplete="accuracy" />
                    <x-input-error class="mt-2" :messages="$errors->get('accuracy')" />
                </div>
                <div>
                    <x-input-label for="magic" :value="__('Magic')" />
                    <x-number-input id="magic" name="magic" type="number" class="mt-1 block w-full"
                        :value="old('magic', $character->magic)" required autofocus autocomplete="magic" />
                    <x-input-error class="mt-2" :messages="$errors->get('magic')" />
                </div>
                <x-input-error class="mt-2" :messages="$errors->get('total')" />
                <div class="flex items-center gap-4 justify-center">
                    <x-primary-button>{{ __('Save') }}</x-primary-button>
        
                    @if (session('status') === 'profile-updated')
                        <p
                            x-data="{ show: true }"
                            x-show="show"
                            x-transition
                            x-init="setTimeout(() => show = false, 2000)"
                            class="text-sm text-gray-600 dark:text-gray-400"
                        >{{ __('Saved.') }}</p>
                    @endif
                </div>
            </form>

        </div>
    </x-modal>
@endsection
