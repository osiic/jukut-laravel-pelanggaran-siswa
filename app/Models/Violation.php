<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Violation extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'teacher_id', 'rule_id', 'reason', 'punishment'];

    // Relasi ke User (Siswa)
    public function student()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    // Relasi ke User (Guru)
    public function teacher()
    {
        return $this->belongsTo(User::class, 'teacher_id');
    }

    // Relasi ke Rule (Pelanggaran)
    public function rule()
    {
        return $this->belongsTo(Rule::class);
    }
}
