<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ChatQuery extends Model
{
    protected $hidden = ['created_at', 'updated_at'];
    protected $fillable = [
        'chat_question_id',
        'order_id',
        'user_id',
        'name',
        'image',
    ];
}