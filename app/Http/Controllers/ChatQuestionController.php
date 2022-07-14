<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ChatQuestionController extends Controller
{
    public function index() { 
     $chat_questions = \App\ChatQuestion::all();
     $question_options = \App\ChatquestionOption::all();
            return view('backend.chat_questions.index', compact('chat_questions','question_options'));
    }


    public function create() { 
        $chat_questions = \App\ChatQuestion::all();
        $question_options = \App\ChatquestionOption::all();
             return view('backend.chat_questions.create', compact('chat_questions','question_options'));
    }

    public function store(Request $request) {

        $this->validate($request, [            
            'question' => 'required',
            // 'dependent_question_id' => 'required',
            // 'dependent_option_id' => 'required',
            'question_type' => 'required',
        ]);

        $chat_question = \App\ChatQuestion::create([
             'question' => $request->input('question'),  
              'dependent_question_id' => $request->input('dependent_question_id'), 
               'dependent_option_id' => $request->input('dependent_option_id'), 
                'question_type' => $request->input('question_type'), 
        ]);

        session()->flash('success', 'New Chat Question is create Successfully');
        return redirect()->route('backend.chat_questions.index');
    }
}