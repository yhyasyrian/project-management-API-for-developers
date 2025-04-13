<?php

namespace App\Models;

use App\Enums\TypeContactEnum;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ContactInformation extends Model
{
    protected $table = 'contact_information';
    protected $fillable = [
        'type',
        'value',
        'user_id'
    ];
    protected $casts = [
        'type' => TypeContactEnum::class,
    ];
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

}
