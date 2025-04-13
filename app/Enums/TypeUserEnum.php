<?php

namespace App\Enums;

enum TypeUserEnum:string
{
    case DEVELOPER = 'developer';
    case ADMIN = 'admin';
    case CLIENT = 'client';
    case USER = 'user';
}
