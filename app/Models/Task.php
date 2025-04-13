<?php

namespace App\Models;

use App\Enums\StatusTaskEnum;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Task extends Model
{
    protected $table = 'tasks';
    protected $fillable = [
        'name',
        'project_id',
        'information',
        'status',
        'can_view_for_client'
    ];
    protected $casts = [
        'status' => StatusTaskEnum::class,
        'can_view_for_client' => 'boolean',
    ];
    public function canViewForClient(): bool
    {
        return $this->can_view_for_client;
    }
    public function project(): BelongsTo
    {
        return $this->belongsTo(Project::class);
    }
}
