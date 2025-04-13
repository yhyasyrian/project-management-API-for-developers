<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Certification extends Model
{
    protected $table = 'certifications';
    protected $fillable = [
        'name',
        'description',
        'date',
        'url',
        'id_check'
    ];
    protected $casts = [
        'date' => 'datetime',
    ];
}
