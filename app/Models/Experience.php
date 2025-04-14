<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Experience extends Model
{
    use HasFactory;
    protected $table = 'experiences';
    protected $fillable = [
        'name',
        'content',
        'start_date',
        'end_date'
    ];
    protected $casts = [
        'start_date' => 'datetime',
        'end_date' => 'datetime',
    ];
    public $timestamps = false;
}
