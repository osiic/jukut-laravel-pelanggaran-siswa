<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('violations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // Siswa
            $table->foreignId('teacher_id')->constrained('users')->onDelete('cascade'); // Guru yang memberikan hukuman
            $table->foreignId('rule_id')->constrained()->onDelete('cascade'); // Pelanggaran berdasarkan tabel rules
            $table->text('reason')->nullable(); // Alasan pelanggaran
            $table->text('punishment')->nullable(); // Hukuman yang diberikan
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('violations');
    }
};
