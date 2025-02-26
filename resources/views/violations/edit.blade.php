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
            {{ __('Edit Violation') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
            {{ __("Modify violation details including the student, teacher, rule, reason, and punishment.") }}
        </p>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <form action="{{ route('violations.update', $violation->id) }}" method="POST" class="bg-white dark:bg-gray-800 p-6 shadow sm:rounded-lg mt-6 space-y-6">
                @csrf
                @method('PUT')

                <!-- Student Selection -->
                <div>
                    <x-input-label for="user_id" :value="__('Student')" />
                    <select id="user_id" name="user_id" class="mt-1 block w-full p-2 border rounded dark:bg-gray-700 dark:text-white">
                        @foreach ($students as $student)
                            <option value="{{ $student->id }}" {{ $violation->user_id == $student->id ? 'selected' : '' }}>
                                {{ $student->name }}
                            </option>
                        @endforeach
                    </select>
                    <x-input-error class="mt-2" :messages="$errors->get('user_id')" />
                </div>

                <!-- Teacher Selection -->
                <div>
                    <x-input-label for="teacher_id" :value="__('Teacher')" />
                    <select id="teacher_id" name="teacher_id" class="mt-1 block w-full p-2 border rounded dark:bg-gray-700 dark:text-white">
                        @foreach ($teachers as $teacher)
                            <option value="{{ $teacher->id }}" {{ $violation->teacher_id == $teacher->id ? 'selected' : '' }}>
                                {{ $teacher->name }}
                            </option>
                        @endforeach
                    </select>
                    <x-input-error class="mt-2" :messages="$errors->get('teacher_id')" />
                </div>

                <!-- Rule Selection -->
                <div>
                    <x-input-label for="rule_id" :value="__('Rule')" />
                    <select id="rule_id" name="rule_id" class="mt-1 block w-full p-2 border rounded dark:bg-gray-700 dark:text-white">
                        @foreach ($rules as $rule)
                            <option value="{{ $rule->id }}" {{ $violation->rule_id == $rule->id ? 'selected' : '' }}>
                                {{ $rule->rule }}
                            </option>
                        @endforeach
                    </select>
                    <x-input-error class="mt-2" :messages="$errors->get('rule_id')" />
                </div>

                <!-- Reason Input -->
                <div>
                    <x-input-label for="reason" :value="__('Reason')" />
                    <textarea id="reason" name="reason" class="mt-1 block w-full p-2 border rounded dark:bg-gray-700 dark:text-white" rows="3">{{ old('reason', $violation->reason) }}</textarea>
                    <x-input-error class="mt-2" :messages="$errors->get('reason')" />
                </div>

                <!-- Punishment Input -->
                <div>
                    <x-input-label for="punishment" :value="__('Punishment')" />
                    <textarea id="punishment" name="punishment" class="mt-1 block w-full p-2 border rounded dark:bg-gray-700 dark:text-white" rows="3">{{ old('punishment', $violation->punishment) }}</textarea>
                    <x-input-error class="mt-2" :messages="$errors->get('punishment')" />
                </div>

                <!-- Submit Button -->
                <div class="flex items-center gap-4">
                    <x-primary-button>{{ __('Update') }}</x-primary-button>
                    <a href="{{ route('violations.index') }}" class="text-gray-600 dark:text-gray-400 hover:text-gray-800 dark:hover:text-gray-200">
                        {{ __('Cancel') }}
                    </a>
                </div>

                @if (session('status') === 'violation-updated')
                    <p
                        x-data="{ show: true }"
                        x-show="show"
                        x-transition
                        x-init="setTimeout(() => show = false, 2000)"
                        class="text-sm text-gray-600 dark:text-gray-400"
                    >{{ __('Violation successfully updated.') }}</p>
                @endif
            </form>
        </div>
    </div>
</x-app-layout>
