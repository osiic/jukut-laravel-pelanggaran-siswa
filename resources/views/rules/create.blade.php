<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Add Rule') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 shadow sm:rounded-lg p-6">
                <form action="{{ route('rules.store') }}" method="POST">
                    @csrf

                    <div>
                        <x-input-label for="rule" :value="__('Rule')" />
                        <x-text-input id="rule" name="rule" type="text" class="mt-1 block w-full" required />
                        <x-input-error class="mt-2" :messages="$errors->get('rule')" />
                    </div>

                    <div class="mt-4">
                        <x-input-label for="points" :value="__('Points')" />
                        <x-text-input id="points" name="points" type="number" class="mt-1 block w-full" required />
                        <x-input-error class="mt-2" :messages="$errors->get('points')" />
                    </div>

                    <div class="mt-4">
                        <x-primary-button>{{ __('Save') }}</x-primary-button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
