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
            ['rule' => 'Masuk atau keluar sekolah dengan cara melompat atau menerobos pagar', 'points' => 15],
            ['rule' => 'Menggunakan jaket atau atribut dengan identitas kelompok/partai/ormas', 'points' => 15],
            ['rule' => 'Membuat kegaduhan atau keonaran yang mengganggu KBM', 'points' => 15],
            ['rule' => 'Membawa, menyimpan, dan mengonsumsi rokok/vape di lingkungan sekolah', 'points' => 20],
            ['rule' => 'Memberikan keterangan atau pernyataan palsu', 'points' => 20],
            ['rule' => 'Menindik telinga (laki-laki) atau dengan sengaja menambah tindik (perempuan)', 'points' => 30],
            ['rule' => 'Tidak sekolah tanpa surat keterangan', 'points' => 30],
            ['rule' => 'Dengan sengaja melakukan perusakan barang milik orang lain atau sekolah', 'points' => 30],
            ['rule' => 'Berlaku tidak sopan atau menghina kepala sekolah, guru, atau karyawan', 'points' => 50],
            ['rule' => 'Menyimpan, menyebarkan, atau menonton konten pornografi di area sekolah', 'points' => 50],
            ['rule' => 'Menjadi anggota organisasi terlarang atau kegiatan ilegal', 'points' => 50],
            ['rule' => 'Berjudi di area sekolah dengan menggunakan uang', 'points' => 50],
            ['rule' => 'Melakukan pemalsuan tanda tangan kepala sekolah, guru, orang tua, atau pihak lain', 'points' => 50],
            ['rule' => 'Meminta paksa uang atau barang orang lain (pemerasan)', 'points' => 50],
            ['rule' => 'Melakukan intimidasi terhadap peserta didik lain (bullying)', 'points' => 60],
            ['rule' => 'Berkelahi di lingkungan sekolah', 'points' => 60],
            ['rule' => 'Membawa, menyimpan, atau menyembunyikan petasan/bahan peledak/senjata tajam', 'points' => 60],
            ['rule' => 'Melakukan perkelahian dengan seragam sekolah di luar lingkungan sekolah', 'points' => 100],
            ['rule' => 'Memicu tawuran yang mengakibatkan korban dari kedua belah pihak', 'points' => 100],
            ['rule' => 'Melakukan tindakan kriminal yang berhubungan dengan pihak kepolisian', 'points' => 100],
            ['rule' => 'Membawa, menyimpan, mengonsumsi, dan mengedarkan minuman keras, narkoba, atau zat adiktif lainnya', 'points' => 100],
            ['rule' => 'Melakukan pemerkosaan, tindakan asusila, atau kehamilan di luar nikah', 'points' => 100],
            ['rule' => 'Menghina atau menjelekkan nama baik sekolah melalui media cetak atau elektronik', 'points' => 100]
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
