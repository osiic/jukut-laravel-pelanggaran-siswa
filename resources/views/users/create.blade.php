<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center">
            <a href="{{ route('users.index') }}" class="text-blue-500 hover:text-blue-700 flex items-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
                </svg>
                <span class="ml-2">{{ __('Back to Users') }}</span>
            </a>
        </div>

        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight mt-2">
            {{ __('Add User') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
            {{ __('Create a new user with their role and information.') }}
        </p>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <form action="{{ route('users.store') }}" method="POST" class="bg-white dark:bg-gray-800 p-6 shadow sm:rounded-lg mt-6 space-y-6">
                @csrf

                <!-- Name Input -->
                <div>
                    <x-input-label for="name" :value="__('Full Name')" />
                    <x-text-input id="name" name="name" type="text" class="mt-1 block w-full" required autocomplete="name" />
                    <x-input-error class="mt-2" :messages="$errors->get('name')" />
                </div>

                <!-- Email Input -->
                <div>
                    <x-input-label for="email" :value="__('Email Address')" />
                    <x-text-input id="email" name="email" type="email" class="mt-1 block w-full" required autocomplete="email" />
                    <x-input-error class="mt-2" :messages="$errors->get('email')" />
                </div>

                <!-- Role Selection -->
                <div>
                    <x-input-label for="role" :value="__('Role')" />
                    <select id="role" name="role" class="mt-1 block w-full p-2 border rounded dark:bg-gray-700 dark:text-white">
                        <option value="student">Student</option>
                        <option value="teacher">Teacher</option>
                    </select>
                    <x-input-error class="mt-2" :messages="$errors->get('role')" />
                </div>

                <!-- Department Selection -->
                <div>
                    <x-input-label for="department_id" :value="__('Department')" />
                    <select id="department_id" name="department_id" class="mt-1 block w-full p-2 border rounded dark:bg-gray-700 dark:text-white">
                        <option value="">-- Select Department --</option>
                        @foreach ($departments as $department)
                            <option value="{{ $department->id }}">{{ $department->name }}</option>
                        @endforeach
                    </select>
                    <x-input-error class="mt-2" :messages="$errors->get('department_id')" />
                </div>

                <!-- Generation Selection -->
                <div>
                    <x-input-label for="generation_id" :value="__('Generation')" />
                    <select id="generation_id" name="generation_id" class="mt-1 block w-full p-2 border rounded dark:bg-gray-700 dark:text-white">
                        <option value="">-- Select Generation --</option>
                        @foreach ($generations as $generation)
                            <option value="{{ $generation->id }}">{{ $generation->year }}</option>
                        @endforeach
                    </select>
                    <x-input-error class="mt-2" :messages="$errors->get('generation_id')" />
                </div>

                <!-- Class Selection -->
                <div>
                    <x-input-label for="class_id" :value="__('Class')" />
                    <select id="class_id" name="class_id" class="mt-1 block w-full p-2 border rounded dark:bg-gray-700 dark:text-white">
                        <option value="">-- Select Class --</option>
                        @foreach ($classes as $class)
                            <option value="{{ $class->id }}">{{ $class->name }}</option>
                        @endforeach
                    </select>
                    <x-input-error class="mt-2" :messages="$errors->get('class_id')" />
                </div>

                <!-- Password Input -->
                <div>
                    <x-input-label for="password" :value="__('Password')" />
                    <x-text-input id="password" name="password" type="password" class="mt-1 block w-full" required autocomplete="new-password" />
                    <x-input-error class="mt-2" :messages="$errors->get('password')" />
                </div>

                <!-- Confirm Password -->
                <div>
                    <x-input-label for="password_confirmation" :value="__('Confirm Password')" />
                    <x-text-input id="password_confirmation" name="password_confirmation" type="password" class="mt-1 block w-full" required autocomplete="new-password" />
                    <x-input-error class="mt-2" :messages="$errors->get('password_confirmation')" />
                </div>

                <!-- Submit Button -->
                <div class="flex items-center gap-4">
                    <x-primary-button>{{ __('Save') }}</x-primary-button>

                    @if (session('status') === 'user-added')
                        <p
                            x-data="{ show: true }"
                            x-show="show"
                            x-transition
                            x-init="setTimeout(() => show = false, 2000)"
                            class="text-sm text-gray-600 dark:text-gray-400"
                        >{{ __('User successfully added.') }}</p>
                    @endif
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
