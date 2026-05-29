<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tenant extends Model
{
    protected $connection = 'central';

    protected $fillable = [
        'name',
        'slug',
        'domain',
        'db_name',
        'is_active',
    ];
}
