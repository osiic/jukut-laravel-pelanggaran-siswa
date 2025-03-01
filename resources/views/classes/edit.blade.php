<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center">
            <a href="{{ route('classes.index') }}" class="text-blue-500 hover:text-blue-700 flex items-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
                </svg>
                <span class="ml-2">{{ __('Back to Classes') }}</span>
            </a>
        </div>

        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight mt-2">
            {{ __('Edit Class') }}
        </h2>
        <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
            {{ __("Modify the class name and update the details.") }}
        </p>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <form action="{{ route('classes.update', $class) }}" method="POST" class="bg-white dark:bg-gray-800 p-6 shadow sm:rounded-lg mt-6 space-y-6">
                @csrf
                @method('PUT')

                <div>
                    <x-input-label for="name" :value="__('Class Name')" />
                    <x-text-input id="name" name="name" type="text" class="mt-1 block w-full" :value="old('name', $class->name)" required autofocus autocomplete="name" />
                    <x-input-error class="mt-2" :messages="$errors->get('name')" />
                </div>

<div>
    <x-input-label for="department_id" :value="__('Department')" />
    <select id="department_id" name="department_id" class="mt-1 block w-full" required>
        @foreach ($departments as $department)
            <option value="{{ $department->id }}" {{ $class->department_id == $department->id ? 'selected' : '' }}>
                {{ $department->name }}
            </option>
        @endforeach
    </select>
</div>

<div>
    <x-input-label for="generation_id" :value="__('Generation')" />
    <select id="generation_id" name="generation_id" class="mt-1 block w-full" required>
        @foreach ($generations as $generation)
            <option value="{{ $generation->id }}" {{ $class->generation_id == $generation->id ? 'selected' : '' }}>
                {{ $generation->year }}
            </option>
        @endforeach
    </select>
</div>


                <div class="flex items-center gap-4">
                    <x-primary-button>{{ __('Update') }}</x-primary-button>

                    @if (session('status') === 'class-updated')
                        <p
                            x-data="{ show: true }"
                            x-show="show"
                            x-transition
                            x-init="setTimeout(() => show = false, 2000)"
                            class="text-sm text-gray-600 dark:text-gray-400"
                        >{{ __('Class successfully updated.') }}</p>
                    @endif
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
