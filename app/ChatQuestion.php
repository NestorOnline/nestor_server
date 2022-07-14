<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ChatQuestion extends Model
{
    protected $hidden = ['created_at', 'updated_at'];
 protected $fillable = [
   'question',  
              'dependent_question_id', 
               'dependent_option_id', 
                'question_type', 
    ];  

 public function chat_question_options() {
        return $this->hasMany('\App\ChatquestionOption', 'question_id');
    }
    
    
}