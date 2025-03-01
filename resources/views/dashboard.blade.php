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
            <div class="bg-white flex flex-col gap-5 dark:bg-gray-800 shadow-lg sm:rounded-lg p-6">
                @if($users->isEmpty())
                    <p class="text-center py-6 text-gray-500 dark:text-gray-400">Users Not Found.</p>
                @else
                    <table class="w-full border-collapse">
                        <thead>
                            <tr class="bg-gray-200 dark:bg-gray-700 text-gray-700 dark:text-gray-200 uppercase text-sm leading-normal">
                                <th class="py-3 px-4 text-left">Name</th>
                                <th class="py-3 px-4 text-left">Email</th>
                                <th class="py-3 px-4 text-left">Department</th>
                                <th class="py-3 px-4 text-left">Generation</th>
                                <th class="py-3 px-4 text-left">Class</th>
                                <th class="py-3 px-4 text-center">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="text-gray-800 dark:text-gray-200">
                            @foreach ($users as $user)
                                <tr class="border-b border-gray-200 dark:border-gray-700 hover:bg-gray-100 dark:hover:bg-gray-700 transition duration-200">
                                    <td class="py-3 px-4">{{ $user->name }}</td>
                                    <td class="py-3 px-4">{{ $user->email }}</td>
                                    <td class="py-3 px-4">{{ $user->department->name ?? '-' }}</td>
                                    <td class="py-3 px-4">{{ $user->generation->year ?? '-' }}</td>
                                    <td class="py-3 px-4">{{ $user->classRoom->name ?? '-' }}</td>
                                    <td class="py-3 px-4 flex justify-center">
                                        <button onclick="showViolations({{ $user->id }})"
                                            class="px-4 py-2 bg-black text-white rounded-md transition hover:bg-gray-900">
                                            Violations
                                        </button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
{{ $users->links("pagination::tailwind") }}
                @endif
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div id="userModal" class="hidden fixed inset-0 flex items-center justify-center bg-gray-900 bg-opacity-50 transition-opacity">
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
                        <th class="py-2 px-4">Actions</th>
                    </tr>
                </thead>
                <tbody id="violations-list" class="text-gray-800 dark:text-gray-200"></tbody>
            </table>

            <!-- Form Tambah Pelanggaran -->
            <h4 class="mt-6 font-semibold">New Violation</h4>
            <form id="create-violation-form" class="flex flex-col gap-2">
                <input type="hidden" id="selected-user-id">

                <div>
                    <x-input-label for="violation-reason" :value="__('Reason')" />
                    <x-text-input id="violation-reason" name="violation-reason" type="text" class="mt-1 block w-full" required autocomplete="name" />
                </div>

                <div>
                    <x-input-label for="violation-punishment" :value="__('Punishment')" />
                    <x-text-input id="violation-punishment" name="violation-reason" type="text" class="mt-1 block w-full" required autocomplete="name" />
                </div>

                <div class="mt-2 mb-4">
                    <select id="rule_id" name="rule_id" class="block w-full p-2 border rounded dark:bg-gray-700 dark:text-white" required>
                        <option value="">-- Select Rule --</option>
                        @foreach($rules as $rule)
                            <option value="{{ $rule->id }}">{{ $rule->rule }} - {{ $rule->points }}</option>
                        @endforeach
                    </select>
                </div>
                <button type="submit" class="px-4 py-2 bg-black text-white rounded-md transition hover:bg-gray-900"> Add Violation</button>
            </form>

            <div class="mt-4 flex justify-end">
                <button onclick="closeModal()" class="px-4 py-2 bg-gray-600 text-white rounded-md hover:bg-gray-700">Close</button>
            </div>
        </div>
    </div>

    <script>
async function showViolations(userId) {
    document.getElementById('selected-user-id').value = userId;
    try {
        const response = await fetch(`/users/violations/${userId}`);
        const data = await response.json();

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
                    <td class="py-2 px-4">
                        <button onclick="deleteViolation(${violation.id})" class="text-red-500 hover:text-red-700">Delete</button>
                    </td>
                </tr>
            `;
            totalPoints += violation.rule.points;
        });

        document.getElementById('violations-list').innerHTML = violationsList;
        document.getElementById('total-points').textContent = totalPoints;
    } catch (error) {
        console.error('Error fetching violations:', error);
    }
}

function closeModal() {
    document.getElementById('userModal').classList.add('hidden');
    document.getElementById('userModal').classList.remove('flex');
}

document.getElementById('create-violation-form').addEventListener('submit', async function(event) {
    event.preventDefault();
    const userId = document.getElementById('selected-user-id').value;
    const ruleId = document.getElementById('rule_id').value;
    const reason = document.getElementById('violation-reason').value;
    const punishment = document.getElementById('violation-punishment').value;

    try {
        await fetch(`/users/violations/${userId}`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify({ rule_id: ruleId, reason: reason, punishment: punishment })
        });

        showViolations(userId);
    } catch (error) {
        console.error('Error creating violation:', error);
    }
});

async function deleteViolation(id) {
    try {
        await fetch(`/users/violations/${id}`, {
            method: 'DELETE',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            }
        });

        showViolations(document.getElementById('selected-user-id').value);
    } catch (error) {
        console.error('Error deleting violation:', error);
    }
}
    </script>
</x-app-layout>
