<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TasklistModel extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'tasklists';

    protected $fillable = [
        'id',
        'name',
        'user_id',
        'description',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    public function tasks()
    {
        return $this->hasMany(TaskModel::class);
    }

    public function users()
    {
        return $this->belongsTo(UserModel::class);
    }
}
