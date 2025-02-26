<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Dashboard Management') }}
            </h2>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 text-gray-800 dark:text-gray-200">
            <div class="bg-white dark:bg-gray-800 shadow-lg sm:rounded-lg p-6">
                <table class="w-full border-collapse">
                    <thead>
                        <tr class="bg-gray-200 dark:bg-gray-700 text-gray-700 dark:text-gray-200 uppercase text-sm leading-normal">
                            <th class="py-3 px-6 text-left">Name</th>
                            <th class="py-3 px-6 text-left">Email</th>
                            <th class="py-3 px-6 text-left">Department</th>
                            <th class="py-3 px-6 text-left">Generation</th>
                            <th class="py-3 px-6 text-left">Class</th>
                            <th class="py-3 px-6 text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="text-gray-800 dark:text-gray-200">
                        @foreach ($users as $user)
                            <tr class="border-b border-gray-200 dark:border-gray-700 hover:bg-gray-100 dark:hover:bg-gray-700 transition duration-200">
                                <td class="py-4 px-6">{{ $user->name }}</td>
                                <td class="py-4 px-6">{{ $user->email }}</td>
                                <td class="py-4 px-6">{{ $user->department->name ?? '-' }}</td>
                                <td class="py-4 px-6">{{ $user->generation->year ?? '-' }}</td>
                                <td class="py-4 px-6">{{ $user->classRoom->name ?? '-' }}</td>
                                <td class="py-4 px-6 flex flex-col gap-2">
                                    <button onclick="showViolations({{ $user->id }})"
                                        class="px-4 py-2 bg-black text-white rounded-md transition hover:bg-gray-900">
                                        View
                                    </button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                @if($users->isEmpty())
                    <p class="text-center py-6 text-gray-500 dark:text-gray-400">No users found.</p>
                @endif
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div id="userModal" class="hidden fixed inset-0 items-center justify-center bg-gray-900 bg-opacity-50">
        <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow-lg w-2/3">
            <h3 class="text-lg font-semibold mb-4 text-gray-800 dark:text-gray-200">Violations Details</h3>

            <h4 class="font-semibold mb-2">Total Points: <span id="total-points" class="text-red-500">0</span></h4>

            <table class="w-full border-collapse">
                <thead>
                    <tr class="bg-gray-200 dark:bg-gray-700 text-gray-700 dark:text-gray-200 uppercase text-sm">
                        <th class="py-2 px-4">No</th>
                        <th class="py-2 px-4">Rule</th>
                        <th class="py-2 px-4">Reason</th>
                        <th class="py-2 px-4">Punishment</th>
                        <th class="py-2 px-4">Points</th>
                    </tr>
                </thead>
                <tbody id="violations-list" class="text-gray-800 dark:text-gray-200"></tbody>
            </table>

            <div class="mt-4 flex justify-end gap-4">
                <button onclick="closeModal()" class="px-4 py-2 bg-gray-600 text-white rounded-md hover:bg-gray-700">Close</button>
            </div>
        </div>
    </div>

    <script>
        function showViolations(userId) {
            fetch(`/users/${userId}/violations`)
                .then(response => response.json())
                .then(data => {
                    document.getElementById('userModal').classList.remove('hidden');
                    document.getElementById('userModal').classList.add('flex');

                    let violationsList = '';
                    let totalPoints = 0;
                    data.forEach((violation, index) => {
                        violationsList += `
                            <tr class="border-b border-gray-200 dark:border-gray-700">
                                <td class="py-2 px-4">${index + 1}</td>
                                <td class="py-2 px-4">${violation.rule.rule}</td>
                                <td class="py-2 px-4">${violation.reason}</td>
                                <td class="py-2 px-4">${violation.punishment}</td>
                                <td class="py-2 px-4">${violation.rule.points}</td>
                            </tr>
                        `;
                        totalPoints += violation.rule.points;
                    });

                    document.getElementById('violations-list').innerHTML = violationsList;
                    document.getElementById('total-points').textContent = totalPoints;

                })
                .catch(error => console.error('Error fetching violations:', error));
        }

        function closeModal() {
            document.getElementById('userModal').classList.add('hidden');
            document.getElementById('userModal').classList.remove('flex');
        }
    </script>
</x-app-layout>
