<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class UserModel extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'id',
        'username',
        'password',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $table = 'users';
}
