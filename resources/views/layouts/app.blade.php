@vite(['resources/css/app.css', 'resources/js/app.js'])
@php
    use Illuminate\Support\Str;
@endphp

<!DOCTYPE html>
<html class="dark" lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased bg-gray-100 dark:bg-gray-900">
    <div class="flex min-h-screen">

        <!-- Sidebar (Hanya jika role 'teacher' dan bukan di halaman home) -->
            <aside class="w-72 bg-white dark:bg-gray-800 shadow-lg min-h-screen p-4">
                <div class="flex items-center justify-between mb-4 ml-3 mt-2">
                    <h2 class="text-xl font-semibold text-gray-800 dark:text-gray-200">Dashboard</h2>
                </div>

                <nav>
                    <!-- MAIN SECTION -->
                    <h3 class="px-4 text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase mb-2 mt-10">Main</h3>
                    <!-- Nested Department Section -->
                    <div id="departments-nav"> </div>
@if(auth()->user() && auth()->user()->role === 'teacher' && !Str::startsWith(request()->path(), 'home'))
                    <!-- REGISTRATION SECTION -->
                    <h3 class="px-4 mt-10 text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase">Registration</h3>
                    <a href="{{ route('departments.index') }}" class="flex items-center py-3 px-4 rounded-lg text-gray-700 dark:text-gray-200 hover:bg-gray-200 dark:hover:bg-gray-700 cursor-pointer">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M16 12V8m0 4l-4 4m4-4h-8"/>
                        </svg>
                        Departments
                    </a>
                    <a href="{{ route('generations.index') }}" class="flex items-center py-3 px-4 rounded-lg text-gray-700 dark:text-gray-200 hover:bg-gray-200 dark:hover:bg-gray-700 cursor-pointer">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M16 12V8m0 4l-4 4m4-4h-8"/>
                        </svg>
                        Generations
                    </a>
                    <a href="{{ route('classes.index') }}" class="flex items-center py-3 px-4 rounded-lg text-gray-700 dark:text-gray-200 hover:bg-gray-200 dark:hover:bg-gray-700 cursor-pointer">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M16 12V8m0 4l-4 4m4-4h-8"/>
                        </svg>
                        Classes
                    </a>
                    <a href="{{ route('users.index') }}" class="flex items-center py-3 px-4 rounded-lg text-gray-700 dark:text-gray-200 hover:bg-gray-200 dark:hover:bg-gray-700 cursor-pointer">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M16 12V8m0 4l-4 4m4-4h-8"/>
                        </svg>
                        Users
                    </a>
                    <a href="{{ route('rules.index') }}" class="flex items-center py-3 px-4 rounded-lg text-gray-700 dark:text-gray-200 hover:bg-gray-200 dark:hover:bg-gray-700 cursor-pointer">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M16 12V8m0 4l-4 4m4-4h-8"/>
                        </svg>
                        Rules
                    </a>
                    <a href="{{ route('violations.index') }}" class="flex items-center py-3 px-4 rounded-lg text-gray-700 dark:text-gray-200 hover:bg-gray-200 dark:hover:bg-gray-700 cursor-pointer">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M16 12V8m0 4l-4 4m4-4h-8"/>
                        </svg>
                        Violations
                    </a>
        @endif
                </nav>
            </aside>

        <!-- Main Content -->
        <div class="flex-1">
            @include('layouts.navigation')

            <!-- Page Heading -->
            @isset($header)
                <header class="bg-white dark:bg-gray-800 shadow">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endisset

            <!-- Page Content -->
            <main>
                {{ $slot }}
            </main>
        </div>
    </div>
    <script>
document.addEventListener("DOMContentLoaded", function () {
    fetchDepartments();
});

async function fetchDepartments() {
    try {
        const response = await fetch("/departments/list");
const departments = await response.json();
console.log(departments)
        renderDepartments(departments);
    } catch (error) {
        console.error("Error fetching departments:", error);
    }
}

function renderDepartments(departments) {
    const navContainer = document.getElementById("departments-nav");
    navContainer.innerHTML = ""; // Clear previous content

    if (!Array.isArray(departments) || departments.length < 3) {
        console.error("Data format is incorrect:", departments);
        return;
    }

    const [departmentsList, generationsList, classesList] = departments;

    departmentsList.forEach(department => {
        const departmentEl = document.createElement("details");
        departmentEl.classList.add("group");

        departmentEl.innerHTML = `
            <summary class="flex items-center justify-between py-3 px-4 rounded-lg text-gray-700 dark:text-gray-200 hover:bg-gray-200 dark:hover:bg-gray-700 cursor-pointer">
                <div class="flex items-center">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m0 0l-6-6m6 6l6-6"/>
                    </svg>
                    ${department.name}
                </div>
                <span class="group-open:rotate-90 transition-transform">▼</span>
            </summary>
        `;

        const generationsContainer = document.createElement("div");
        generationsContainer.classList.add("pl-6", "mt-2");

        // Filter generations untuk department ini
        const relatedGenerations = generationsList;

        relatedGenerations.forEach(generation => {
            const generationEl = document.createElement("details");
            generationEl.classList.add("group");

            generationEl.innerHTML = `
                <summary class="flex justify-between items-center py-2 px-4 rounded-lg text-gray-600 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-600 cursor-pointer">
                    ${generation.year}
                    <span class="group-open:rotate-90 transition-transform">▼</span>
                </summary>
            `;

            const classesContainer = document.createElement("div");
            classesContainer.classList.add("pl-6");

            // Filter kelas yang sesuai dengan department & generation
            const relatedClasses = classesList.filter(cls => cls.department_id === department.id && cls.generation_id === generation.id);

            relatedClasses.forEach(classItem => {
                const classEl = document.createElement("div");
                classEl.classList.add("group");

                classEl.innerHTML = `
@if(auth()->user() && auth()->user()->role === 'teacher' && !Str::startsWith(request()->path(), 'home'))
                    <a href="/dashboard/${department.name}/${generation.year}/${classItem.name}" class="flex items-center py-3 px-4 rounded-lg text-gray-700 dark:text-gray-200 hover:bg-gray-200 dark:hover:bg-gray-700 cursor-pointer">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M16 12V8m0 4l-4 4m4-4h-8"/>
                        </svg>
                        ${classItem.name}
                    </a>
@else

                    <a href="/home/${department.name}/${generation.year}/${classItem.name}" class="flex items-center py-3 px-4 rounded-lg text-gray-700 dark:text-gray-200 hover:bg-gray-200 dark:hover:bg-gray-700 cursor-pointer">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M16 12V8m0 4l-4 4m4-4h-8"/>
                        </svg>
                        ${classItem.name}
                    </a>
@endif
                `;

                classesContainer.appendChild(classEl);
            });

            generationEl.appendChild(classesContainer);
            generationsContainer.appendChild(generationEl);
        });

        departmentEl.appendChild(generationsContainer);
        navContainer.appendChild(departmentEl);
    });
}
    </script>
</body>
</html>
