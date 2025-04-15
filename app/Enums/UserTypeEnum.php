<?php

namespace App\Enums;

enum UserTypeEnum:string
{
    case ADMIN = 'admin';
    case CLIENT = 'client';
    case USER = 'user';
}
