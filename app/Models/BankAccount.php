<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class BankAccount extends Model
{
    use HasFactory;
    protected $table = 'bank_accounts';
    protected $fillable = [
        'name',
        'bank',
        'balance',
        'user',
        'password'
    ];
    protected $casts = [
        'balance' => 'decimal:2',
    ];
}
