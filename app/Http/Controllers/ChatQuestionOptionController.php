<?php

namespace App\Http\Controllers;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\ChatQuestion;
use App\ChatquestionOption;
use Mail;
use App\Mail\SendMail;
use Illuminate\Support\Str;
use Illuminate\Http\Request;

class ChatQuestionOptionController extends Controller
{
   public function index() { 
              $chatquestion_options = \App\ChatquestionOption::all();
            return view('backend.chatquestion_options.index', compact('chatquestion_options'));
    }


    public function create() { 
        $chat_questions = \App\ChatQuestion::all();
             return view('backend.chatquestion_options.create', compact('chat_questions'));
    }

    public function store(Request $request) {

        $this->validate($request, [  
            'question_id' => 'required',
              'option' => 'required',
               'option_sn' => 'required',   
        ]);

        $chat_question = \App\ChatquestionOption::create([
             'question_id' => $request->input('question_id'),  
              'option' => $request->input('option'), 
               'option_sn' => $request->input('option_sn')
        ]);

        session()->flash('success', 'New Chat Question is create Successfully');
        return redirect()->route('backend.chatquestion_options.index');
    }
}