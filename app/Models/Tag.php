<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Tag extends Model
{
    protected $table = 'tags';
    protected $fillable = [
        'name',
        'project_id'
    ];
    public function project(): BelongsTo
    {
        return $this->belongsTo(Project::class);
    }
}
