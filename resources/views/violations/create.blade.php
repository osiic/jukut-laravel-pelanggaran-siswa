<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center">
            <a href="{{ route('violations.index') }}" class="text-blue-500 hover:text-blue-700 flex items-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
                </svg>
                <span class="ml-2">{{ __('Back to Violations') }}</span>
            </a>
        </div>
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight mt-2">
            {{ __('Add Violation') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <form action="{{ route('violations.store') }}" method="POST" class="bg-white dark:bg-gray-800 p-6 shadow sm:rounded-lg mt-6 space-y-6">
                @csrf

                <!-- Student Selection -->
                <div>
                    <x-input-label for="user_id" :value="__('Student')" />
                    <select id="user_id" name="user_id" class="mt-1 block w-full p-2 border rounded dark:bg-gray-700 dark:text-white" required>
                        <option value="">-- Select Student --</option>
                        @foreach($students as $student)
                            <option value="{{ $student->id }}">{{ $student->name }}</option>
                        @endforeach
                    </select>
                    <x-input-error class="mt-2" :messages="$errors->get('user_id')" />
                </div>

                <!-- Teacher Selection -->
                <div>
                    <x-input-label for="teacher_id" :value="__('Teacher')" />
                    <select id="teacher_id" name="teacher_id" class="mt-1 block w-full p-2 border rounded dark:bg-gray-700 dark:text-white" required>
                        <option value="">-- Select Teacher --</option>
                        @foreach($teachers as $teacher)
                            <option value="{{ $teacher->id }}">{{ $teacher->name }}</option>
                        @endforeach
                    </select>
                    <x-input-error class="mt-2" :messages="$errors->get('teacher_id')" />
                </div>

                <!-- Rule Selection -->
                <div>
                    <x-input-label for="rule_id" :value="__('Rule')" />
                    <select id="rule_id" name="rule_id" class="mt-1 block w-full p-2 border rounded dark:bg-gray-700 dark:text-white" required>
                        <option value="">-- Select Rule --</option>
                        @foreach($rules as $rule)
                            <option value="{{ $rule->id }}">{{ $rule->rule }} - {{ $rule->points }}</option>
                        @endforeach
                    </select>
                    <x-input-error class="mt-2" :messages="$errors->get('rule_id')" />
                </div>

                <!-- Reason Input -->
                <div>
                    <x-input-label for="reason" :value="__('Reason')" />
                    <textarea id="reason" name="reason" class="mt-1 block w-full p-2 border rounded dark:bg-gray-700 dark:text-white"></textarea>
                    <x-input-error class="mt-2" :messages="$errors->get('reason')" />
                </div>

                <!-- Punishment Input -->
                <div>
                    <x-input-label for="punishment" :value="__('Punishment')" />
                    <textarea id="punishment" name="punishment" class="mt-1 block w-full p-2 border rounded dark:bg-gray-700 dark:text-white"></textarea>
                    <x-input-error class="mt-2" :messages="$errors->get('punishment')" />
                </div>

                <!-- Submit Button -->
                <div class="flex items-center gap-4">
                    <x-primary-button>{{ __('Save') }}</x-primary-button>
                    <a href="{{ route('violations.index') }}" class="text-gray-600 dark:text-gray-400 hover:text-gray-800 dark:hover:text-gray-200">{{ __('Cancel') }}</a>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
