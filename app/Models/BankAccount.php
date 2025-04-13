<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BankAccount extends Model
{
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
