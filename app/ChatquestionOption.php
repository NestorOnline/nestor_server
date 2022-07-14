<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ChatquestionOption extends Model
{
       protected $hidden = ['created_at', 'updated_at'];
   protected $fillable = [
              'question_id',  
              'option', 
               'option_sn', 
    ];   
    public function chat_questions() {
         return $this->belongsTo(ChatQuestion::class, 'question_id');
    }

 public function next_chat_questions() {
        return $this->hasMany(ChatQuestion::class, 'dependent_question_id','question_id');
    }

   
}