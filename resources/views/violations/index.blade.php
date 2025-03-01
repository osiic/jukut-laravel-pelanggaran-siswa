<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Violations Management') }}
            </h2>
            <a href="{{ route('violations.create') }}" class="flex items-center gap-2 px-4 py-2 bg-gray-800 dark:bg-gray-200 border border-transparent rounded-md font-semibold text-xs text-white dark:text-gray-800 uppercase tracking-widest hover:bg-gray-700 dark:hover:bg-white focus:outline-none focus:ring-2 focus:ring-indigo-500 transition ease-in-out duration-150">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <line x1="12" y1="5" x2="12" y2="19"></line>
                    <line x1="5" y1="12" x2="19" y2="12"></line>
                </svg>
                Add Violation
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 text-gray-800 dark:text-gray-200">
            @if (session('success'))
                <div class="mb-4 p-4 bg-green-100 dark:bg-green-800 text-green-800 dark:text-green-200 rounded-lg shadow">
                    {{ session('success') }}
                </div>
            @endif
            <div class="mt-4 flex flex-col gap-5 bg-white dark:bg-gray-800 shadow-lg sm:rounded-lg p-6">
                <table class="w-full border-collapse">
                    <thead>
                        <tr class="bg-gray-200 dark:bg-gray-700 text-gray-700 dark:text-gray-200 uppercase text-sm leading-normal">
                            <th class="py-3 px-6 text-left">#</th>
                            <th class="py-3 px-6 text-left">Student</th>
                            <th class="py-3 px-6 text-left">Teacher</th>
                            <th class="py-3 px-6 text-left">Ponits & Rule</th>
                            <th class="py-3 px-6 text-left">Reason</th>
                            <th class="py-3 px-6 text-left">Punishment</th>
                            <th class="py-3 px-6 text-left">Violation Date</th>
                            <th class="py-3 px-6 text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="text-gray-800 dark:text-gray-200">
                        @foreach ($violations as $violation)
                            <tr class="border-b border-gray-200 dark:border-gray-700 hover:bg-gray-100 dark:hover:bg-gray-700 transition duration-200">
                                <td class="py-4 px-6">{{ $loop->iteration }}</td>
                                <td class="py-4 px-6">{{ $violation->student->name }}</td>
                                <td class="py-4 px-6">{{ $violation->teacher->name }}</td>
                                <td class="py-4 px-6">{{ $violation->rule->points }} - {{ $violation->rule->rule }}</td>
                                <td class="py-4 px-6">{{ $violation->reason }}</td>
                                <td class="py-4 px-6">{{ $violation->punishment }}</td>
                                <td class="py-4 px-6">{{ $violation->created_at->format('d M Y H:i') }}</td>
                                <td class="py-4 px-6 flex flex-col gap-2">
                                    <a href="{{ route('violations.edit', $violation->id) }}" class="flex justify-center items-center gap-2 px-4 py-2 border border-gray-800 dark:border-gray-200 rounded-md text-gray-800 dark:text-gray-200 hover:border-gray-600 dark:hover:border-white transition duration-150">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                            <path d="M12 20h9"></path>
                                            <path d="M16.5 3.5a2.1 2.1 0 0 1 3 3L7 19l-4 1 1-4Z"></path>
                                        </svg>
                                        Edit
                                    </a>
                                    <form action="{{ route('violations.destroy', $violation->id) }}" method="POST" class="w-full">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="flex items-center justify-center gap-2 px-4 py-2 w-full bg-red-500 hover:bg-red-600 text-white font-medium rounded-lg transition duration-300" onclick="return confirm('Are you sure?')">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                                <polyline points="3 6 5 6 21 6"></polyline>
                                                <path d="M19 6l-1 14a2 2 0 0 1-2 2H8a2 2 0 0 1-2-2L5 6m5 0V4a2 2 0 0 1 2-2h2a2 2 0 0 1 2 2v2"></path>
                                                <line x1="10" y1="11" x2="10" y2="17"></line>
                                                <line x1="14" y1="11" x2="14" y2="17"></line>
                                            </svg>
                                            Delete
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                @if($violations->isEmpty())
                    <p class="text-center py-6 text-gray-500 dark:text-gray-400">No violations found.</p>
                @endif
{{ $violations->links("pagination::tailwind") }}
            </div>
        </div>
    </div>
</x-app-layout>
