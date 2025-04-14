<?php

namespace App\Models;

use App\Enums\StatusProjectEnum;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Project extends Model
{
    use HasFactory;
    protected $table = 'projects';
    protected $fillable = [
        'name',
        'description',
        'user_id',
        'content',
        'price',
        'url',
        'route_check',
        'status',
        'can_check',
        'start_at',
        'end_at'
    ];
    protected $casts = [
        'start_at' => 'datetime',
        'end_at' => 'datetime',
    ];
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
    public function tasks(): HasMany
    {
        return $this->hasMany(Task::class);
    }
    public function tags(): HasMany
    {
        return $this->hasMany(Tag::class);
    }
    public function getStatusEnumAttribute(): StatusProjectEnum
    {
        return StatusProjectEnum::getStatus($this->status);
    }
    public $timestamps = false;
}
