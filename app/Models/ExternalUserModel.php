<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExternalUserModel extends Model
{
    use HasFactory;

    protected $table = 'external_users';

    protected $primaryKey = 'id';

    protected $guarded = [
        'id'
    ];

    protected $casts = [
        'last_access_date'  => 'datetime:Y-m-d H:i:s',
        'created_at'        => 'datetime:Y-m-d H:i:s',
        'updated_at'        => 'datetime:Y-m-d H:i:s'
    ];
}
