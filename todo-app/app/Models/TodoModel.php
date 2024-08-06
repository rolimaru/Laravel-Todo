<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TodoModel extends Model
{
    use HasFactory;

    protected $table = 'todo';
    protected $fillable = [
        'todo_title',
        'todo_description',
        'todo_status',
        'user_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
