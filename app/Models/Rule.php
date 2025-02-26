<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rule extends Model
{
    use HasFactory;

    protected $fillable = ['rule', 'points'];

    public function violations()
    {
        return $this->hasMany(Violation::class);
    }
}
