<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Tag extends Model
{
    use HasFactory;
    protected $table = 'tags';
    protected $fillable = [
        'name',
        'project_id'
    ];
    public function project(): BelongsTo
    {
        return $this->belongsTo(Project::class);
    }
    public $timestamps = false;
}
