<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Todo extends Model
{
    protected $table = 'todos';
    protected $fillable = [
        'user_id',
        'title',
        'amount',
        'type',
        'description',
        'is_finished',
        'cover',
        'created_at',
        'updated_at'
    ];
    public $timestamps = true;
}
