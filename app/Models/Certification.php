<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Certification extends Model
{
    use HasFactory;
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
    public $timestamps = false;
}
