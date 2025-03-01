<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Profile') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                <div class="max-w-xl">
                    @include('profile.partials.update-profile-information-form')
                </div>
            </div>

            <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                <div class="max-w-xl">
                    <section>
                        <header>
                            <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                                {{ __('Violation Details') }}
                            </h2>

                            <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                                {{ __('Here you can see all violations associated with this user.') }}
                            </p>
                        </header>

                        @php
                            $totalPoints = $violations->sum(fn($violation) => $violation->rule->points);
                        @endphp

                        <div class="mt-6 space-y-4">
                            <div class="p-4 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                                <h3 class="text-md font-semibold text-blue-600">Total Points: {{ $totalPoints }}</h3>
                            </div>

                            @foreach ($violations as $violation)
                                <div class="p-4 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                                    <h3 class="text-md font-semibold text-red-600">{{ $violation->rule->rule }}</h3>
                                    <p class="text-sm text-gray-600 dark:text-gray-400">Points: {{ $violation->rule->points }}</p>
                                    <p class="text-sm text-gray-600 dark:text-gray-400">Reason: {{ $violation->reason }}</p>
                                    <p class="text-sm text-gray-600 dark:text-gray-400">Punishment: {{ $violation->punishment }}</p>
                                    <p class="text-xs text-gray-500 dark:text-gray-300">Date: {{ $violation->created_at->format('d M Y') }}</p>
                                </div>
                            @endforeach
                        </div>
                    </section>
                </div>
            </div>

            <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                <div class="max-w-xl">
                    @include('profile.partials.update-password-form')
                </div>
            </div>

            <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                <div class="max-w-xl">
                    @include('profile.partials.delete-user-form')
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
