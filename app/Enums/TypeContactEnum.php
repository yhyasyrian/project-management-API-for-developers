<?php

namespace App\Enums;

enum TypeContactEnum:string
{
    case WHATSAPP = 'whatsapp';
    case TELEGRAM = 'telegram';
    case EMAIL = 'email';
    public function label(): string
    {
        return $this->value;
    }
}
