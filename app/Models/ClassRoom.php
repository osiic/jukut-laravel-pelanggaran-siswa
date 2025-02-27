<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClassRoom extends Model
{
    use HasFactory;

    protected $table = 'classes'; // Pastikan nama tabel benar
    protected $fillable = ['name', 'department_id', 'generation_id'];

    public function department()
    {
        return $this->belongsTo(Department::class);
    }

    public function generation()
    {
        return $this->belongsTo(Generation::class);
    }
}
