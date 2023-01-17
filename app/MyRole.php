<?php

namespace App;

use Spatie\Permission\Models\Role;

class MyRole extends Role
{
    protected $casts = [
        'created_at' => 'datetime:d M Y H:i:s',
        'updated_at' => 'datetime:d M Y H:i:s',
    ];
}
