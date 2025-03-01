<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Models\Department;
use App\Models\Generation;
use App\Models\ClassRoom;
use App\Models\User;
use App\Models\Rule;
use App\Models\Violation;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $departments = ["RPL", "DKV", "KULINER", "ULW", "PERHOTELAN"];
        $generations = ['X', 'XI', 'XII'];
        $classes = ['A1', 'A2', 'B1', 'B2'];

        // Buat semua generasi terlebih dahulu
        $generationRecords = [];
        foreach ($generations as $year) {
            $generationRecords[$year] = Generation::create(['year' => $year]);
        }

        foreach ($departments as $deptName) {
            $department = Department::create(['name' => $deptName]);

            foreach ($generationRecords as $year => $generation) {
                foreach ($classes as $className) {
                    // Buat kelas dengan department_id dan generation_id yang benar
                    $class = ClassRoom::create([
                        'name' => $className,
                        'department_id' => $department->id,
                        'generation_id' => $generation->id,
                    ]);

                    // Buat 5 siswa untuk setiap kelas
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

        // Tambah guru
        User::create([
            'name' => "Teacher",
            'email' => "guru@example.com",
            'role' => 'teacher',
            'password' => Hash::make('password'),
        ]);

        // Tambah contoh siswa
        User::create([
            'name' => "Siswa",
            'email' => "siswa@example.com",
            'role' => 'student',
            'password' => Hash::make('password'),
        ]);

        // Seed rules
        $rules = [
            ['rule' => 'Terlambat pada jam pertama, pergantian jam, atau istirahat tanpa alasan logis', 'points' => 3],
            ['rule' => 'Mengotori area sekolah', 'points' => 3],
            ['rule' => 'Menerima tamu di sekolah saat KBM tanpa izin dari guru piket', 'points' => 5],
            ['rule' => 'Memakai seragam yang tidak sesuai ketentuan', 'points' => 5],
            ['rule' => 'Mewarnai rambut atau potongan rambut tidak sesuai aturan sekolah', 'points' => 5],
            ['rule' => 'Menggunakan aksesoris berlebihan', 'points' => 5],
            ['rule' => 'Membawa dan menyalahgunakan alat yang tidak berhubungan dengan KBM', 'points' => 5],
            ['rule' => 'Sengaja tidak mengikuti upacara bendera atau mengganggu upacara', 'points' => 10],
            ['rule' => 'Membawa kendaraan ke sekolah yang tidak sesuai standar', 'points' => 10],
            ['rule' => 'Meninggalkan kelas/lingkungan sekolah saat KBM berlangsung tanpa izin', 'points' => 10],
            ['rule' => 'Bersikap tidak sopan terhadap peserta didik lain', 'points' => 15],
        ];

        foreach ($rules as $rule) {
            Rule::create($rule);
        }

        // Assign violations randomly
        $students = User::where('role', 'student')->get();
        $teachers = User::where('role', 'teacher')->whereNotNull('email')->get(); // Only valid teachers
        $rules = Rule::all();

        foreach ($students as $student) {
            // Tentukan jumlah pelanggaran secara random (0 hingga 10)
            $violationCount = rand(0, 10);

            for ($i = 0; $i < $violationCount; $i++) {
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
}
