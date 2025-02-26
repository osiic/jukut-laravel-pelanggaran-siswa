<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\Department;
use App\Models\Generation;
use App\Models\ClassRoom;
use App\Models\User;
use App\Models\Rule;
use App\Models\Violation;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Seed departments, generations, and classes
        $departments = ['Computer Science', 'Mechanical Engineering', 'Electrical Engineering', 'Business Management'];
        $generations = ['2021', '2022', '2023', '2024'];
        $classes = ['A1', 'A2', 'B1', 'B2'];

        foreach ($departments as $deptName) {
            $department = Department::create(['name' => $deptName]);

            foreach ($generations as $year) {
                $generation = Generation::create(['year' => $year]);

                foreach ($classes as $className) {
                    $class = ClassRoom::create(['name' => $className]);

                    // Create students with details
                    for ($i = 1; $i <= 5; $i++) {
                        User::create([
                            'name' => "Student {$i} {$deptName} {$year} {$className}",
                            'email' => Str::lower("student{$i}_{$deptName}_{$year}_{$className}@example.com"),
                            'role' => 'student',
                            'password' => Hash::make('password'),
                            'department_id' => $department->id,
                            'generation_id' => $generation->id,
                            'class_id' => $class->id,
                        ]);
                    }
                }
            }
        }

        // Create teachers
        for ($i = 1; $i <= 10; $i++) {
            User::create([
                'name' => "Teacher {$i}",
                'email' => "teacher{$i}@example.com",
                'role' => 'teacher',
                'password' => Hash::make('password'),
            ]);
        }

        User::create([
            'name' => "Teacher",
            'email' => "guru@example.com",
            'role' => 'teacher',
            'password' => Hash::make('password'),
        ]);

        User::create([
            'name' => "Siswa",
            'email' => "siswa@example.com",
            'role' => 'student',
            'password' => Hash::make('password'),
        ]);



        // Create rules
        $rules = [
            ['rule' => 'Terlambat masuk kelas', 'points' => 5],
            ['rule' => 'Tidak memakai seragam lengkap', 'points' => 3],
            ['rule' => 'Bolos tanpa izin', 'points' => 10],
            ['rule' => 'Merokok di lingkungan sekolah', 'points' => 15],
            ['rule' => 'Membawa barang terlarang', 'points' => 20],
            ['rule' => 'Bertengkar dengan teman', 'points' => 8],
            ['rule' => 'Menggunakan HP saat pelajaran', 'points' => 4],
            ['rule' => 'Tidak mengerjakan tugas', 'points' => 2],
            ['rule' => 'Makan di dalam kelas', 'points' => 1],
            ['rule' => 'Mengganggu teman saat pelajaran', 'points' => 3],
        ];

        foreach ($rules as $rule) {
            Rule::create($rule);
        }

        // Assign violations randomly
        $students = User::where('role', 'student')->get();
        $teachers = User::where('role', 'teacher')->whereNotNull('email')->get(); // Only valid teachers
        $rules = Rule::all();

        foreach ($students as $student) {
            $randomTeacher = $teachers->random();
            $randomRule = $rules->random();

            Violation::create([
                'user_id' => $student->id,
                'teacher_id' => $randomTeacher->id,
                'rule_id' => $randomRule->id,
                'reason' => 'Pelanggaran acak yang dilakukan siswa.',
                'punishment' => 'Diberikan teguran lisan.',
            ]);
        }
    }
}
