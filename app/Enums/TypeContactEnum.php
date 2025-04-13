<?php

namespace App\Enums;

enum TypeContactEnum:string
{
    case WHATSAPP = 'whatsapp';
    case TELEGRAM = 'telegram';
    case EMAIL = 'email';
}
