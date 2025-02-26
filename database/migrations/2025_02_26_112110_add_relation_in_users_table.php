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
        Schema::table('users', function (Blueprint $table) {
            $table->foreignId('department_id')->nullable()->after('password')->constrained()->onDelete('cascade');
            $table->foreignId('generation_id')->nullable()->after('department_id')->constrained()->onDelete('cascade');
            $table->foreignId('class_id')->nullable()->after('generation_id')->constrained()->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['department_id']);
            $table->dropForeign(['generation_id']);
            $table->dropForeign(['class_id']);

            $table->dropColumn(['department_id', 'generation_id', 'class_id']);
        });
    }
};
