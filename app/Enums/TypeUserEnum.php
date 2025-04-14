<?php

namespace App\Enums;

enum TypeUserEnum:string
{
    case ADMIN = 'admin';
    case CLIENT = 'client';
    case USER = 'user';
}
