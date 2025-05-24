<?php

namespace App\Enums;

enum UserRole: string
{
    case Admin = 'admin';

    case SuperAdmin = 'super-admin';
    case Manager = 'manager';
    case Editor = 'editor';
    case User = 'user';
}
