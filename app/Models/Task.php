<?php

namespace App\Models;

use App\Enums\TaskStatusEnum;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Task extends Model
{
    use HasFactory;
    protected $table = 'tasks';
    protected $fillable = [
        'name',
        'project_id',
        'content',
        'status',
        'can_view_for_client',
    ];
    protected $casts = [
        'status' => TaskStatusEnum::class,
        'can_view_for_client' => 'boolean',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
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
