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
            {{ __('Edit User') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
            {{ __("Modify the user's details including their role, department, generation, and class.") }}
        </p>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <form action="{{ route('users.update', $user) }}" method="POST" class="bg-white dark:bg-gray-800 p-6 shadow sm:rounded-lg mt-6 space-y-6">
                @csrf
                @method('PUT')

                <!-- Name Input -->
                <div>
                    <x-input-label for="name" :value="__('Full Name')" />
                    <x-text-input id="name" name="name" type="text" class="mt-1 block w-full" :value="old('name', $user->name)" required autocomplete="name" />
                    <x-input-error class="mt-2" :messages="$errors->get('name')" />
                </div>

                <!-- Email Input -->
                <div>
                    <x-input-label for="email" :value="__('Email Address')" />
                    <x-text-input id="email" name="email" type="email" class="mt-1 block w-full" :value="old('email', $user->email)" required autocomplete="email" />
                    <x-input-error class="mt-2" :messages="$errors->get('email')" />
                </div>

                <!-- Role Selection -->
                <div>
                    <x-input-label for="role" :value="__('Role')" />
                    <select id="role" name="role" class="mt-1 block w-full p-2 border rounded dark:bg-gray-700 dark:text-white">
                        <option value="student" {{ $user->role === 'student' ? 'selected' : '' }}>Student</option>
                        <option value="teacher" {{ $user->role === 'teacher' ? 'selected' : '' }}>Teacher</option>
                    </select>
                    <x-input-error class="mt-2" :messages="$errors->get('role')" />
                </div>

                <!-- Department Selection -->
                <div>
                    <x-input-label for="department_id" :value="__('Department')" />
                    <select id="department_id" name="department_id" class="mt-1 block w-full p-2 border rounded dark:bg-gray-700 dark:text-white">
                        <option value="">-- Select Department --</option>
                        @foreach ($departments as $department)
                            <option value="{{ $department->id }}" {{ $user->department_id === $department->id ? 'selected' : '' }}>
                                {{ $department->name }}
                            </option>
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
                            <option value="{{ $generation->id }}" {{ $user->generation_id === $generation->id ? 'selected' : '' }}>
                                {{ $generation->year }}
                            </option>
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
                            <option value="{{ $class->id }}" {{ $user->class_id === $class->id ? 'selected' : '' }}>
                                {{ $class->name }}
                            </option>
                        @endforeach
                    </select>
                    <x-input-error class="mt-2" :messages="$errors->get('class_id')" />
                </div>

                <!-- Password Input (Optional) -->
                <div>
                    <x-input-label for="password" :value="__('New Password (Optional)')" />
                    <x-text-input id="password" name="password" type="password" class="mt-1 block w-full" autocomplete="new-password" />
                    <x-input-error class="mt-2" :messages="$errors->get('password')" />
                </div>

                <!-- Confirm Password -->
                <div>
                    <x-input-label for="password_confirmation" :value="__('Confirm New Password')" />
                    <x-text-input id="password_confirmation" name="password_confirmation" type="password" class="mt-1 block w-full" autocomplete="new-password" />
                    <x-input-error class="mt-2" :messages="$errors->get('password_confirmation')" />
                </div>

                <!-- Submit Button -->
                <div class="flex items-center gap-4">
                    <x-primary-button>{{ __('Update') }}</x-primary-button>

                    @if (session('status') === 'user-updated')
                        <p
                            x-data="{ show: true }"
                            x-show="show"
                            x-transition
                            x-init="setTimeout(() => show = false, 2000)"
                            class="text-sm text-gray-600 dark:text-gray-400"
                        >{{ __('User successfully updated.') }}</p>
                    @endif
                </div>
            </form>
        </div>
    </div>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        const departmentSelect = document.getElementById("department_id");
        const generationSelect = document.getElementById("generation_id");
        const classSelect = document.getElementById("class_id");

        function fetchClasses() {
            const departmentId = departmentSelect.value;
            const generationId = generationSelect.value;

            if (departmentId && generationId) {
                fetch(`/get-classes?department_id=${departmentId}&generation_id=${generationId}`)
                    .then(response => response.json())
                    .then(data => {
                        classSelect.innerHTML = `<option value="">-- Select Class --</option>`;
                        data.forEach(classItem => {
                            classSelect.innerHTML += `<option value="${classItem.id}" ${classItem.id === {{ $user->class_id }} ? 'selected' : ''}>${classItem.name}</option>`;
                        });
                    })
                    .catch(error => console.error('Error fetching classes:', error));
            } else {
                classSelect.innerHTML = `<option value="">-- Select Class --</option>`;
            }
        }

        departmentSelect.addEventListener("change", fetchClasses);
        generationSelect.addEventListener("change", fetchClasses);
        fetchClasses(); // Fetch initial class data
    });
</script>
</x-app-layout>
