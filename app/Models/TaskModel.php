<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TaskModel extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'id',
        'name',
        'status',
        'description',
        'tasklist_id',
        'user_id',
        'commentary',
        'created_at',
        'updated_at',
        'deleted_at',
    ];
    protected $table = 'tasks';

    public function tasklists()
    {
        return $this->belongsTo(TasklistModel::class);
    }
}
