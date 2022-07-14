<?php

namespace App\Http\Controllers;

use App\Category;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ChatController extends Controller
{
    protected $category;
    public function __construct(Category $category)
    {
        $this->category = $category;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function chat()
    {
        $site_route = $request->route()->getName();
        $groups = \App\Group::with('groupcategories')->orderBy('id', 'DESC')->get();
        return view('dashboard.chats.chat', compact('site_route', 'groups'));
    }

    public function index(Request $request)
    {
        $site_route = $request->route()->getName();
        $groups = \App\Group::with('groupcategories')->orderBy('id', 'DESC')->get();
        return view('dashboard.chats.index', compact('site_route', 'groups'));
    }

    public function chat_query_list(Request $request)
    {
        $data['chat_queries'] = \App\ChatQuery::orderBy('id', 'DESC')->get();
        return view('backend.chat_queries.index', $data);
    }

    public function indexApp()
    {
        $categories = \App\Category::all();
        if ($categories) {
            echo json_encode($categories);
        } else {
            echo json_encode('Data Does Not Match. Please Try Again');
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        $groups = \App\Group::all();
        return view('backend.categories.create', compact('groups'));
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
        ]);
        $category = \App\Category::create([
            'name' => $request->input('name'),
        ]);

        session()->flash('success', 'New Category is create Successfully');
        return redirect()->route('backend.categories.index');
    }

    public function chat_submit_App(Request $request)
    {
        $user = \App\User::where('mobile', '=', $request->mobile)->where('status', '=', 'verify')->first();
        if ($user) {
            $chat_query = \App\ChatQuery::create([
                'name' => $request->name,
                'chat_question_id' => $request->chat_question_id,
                'order_id' => $request->order_id,
                'user_id' => $user->id,
            ]);
            if ($request->file('image')) {
                $image = $request->file('image');
                $filename = $image->getClientOriginalName();
                $fullname = Str::slug(Str::random(16) . $filename) . '.' . $image->getClientOriginalExtension();
                $image->move("upload", $fullname);
                $chat_query->image = 'upload/' . $fullname;
                $chat_query->save();
            }

        }

        if ($user) {
            if ($chat_query) {
                return response()->json(['status' => true, 'message' => 'We will connect you with our customer support executive soon.'], 200);
            } else {
                return response()->json(['status' => false, 'message' => 'Error Data Does Not Match. Please Try Again'], 401);
            }
        } else {
            return response()->json(['status' => false, 'message' => 'Error Data Does Not Match. Please Try Again'], 401);
        }
    }
    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function introduction(Request $request)
    {
        $chat_query = \App\ChatQuery::create([
            'chat_question_id' => $request->chat_question_id,
            'order_id' => $request->order_id,
            'user_id' => $request->user_id,
        ]);

        $abcd = "";
        $chat_option = "";
        $chat_question = \App\ChatQuestion::with('chat_question_options')->where('question_type', '=', 'single')->first();
        foreach ($chat_question->chat_question_options as $chatquestion_option) {
            $abcd .= "<button type='button' class='btn btn-sm btn-default' onclick='question_second($chatquestion_option->id)'>"
            . $chatquestion_option->option .
                "</button>
                                            <br>";
        }
        $chat_option = "<div class='rightside-details col pr-0'><div class='row m-0 pull-right'><div class='catag-name col pl-0'>" . $abcd . "</div></div></div>";
        return response()->json(['status' => true, 'message' => 'Data Fetch Successfully', 'data' => $chat_question, 'options' => $chat_option], 200);

    }

    public function question_second(Request $request)
    {

        $id = 317;
        $abcd = "";
        $chat_option = "";
        $chat_question = \App\ChatQuestion::with('chat_question_options')->where('dependent_option_id', '=', $request->option_id)->first();
        if ($chat_question == 'Select') {
            foreach ($chat_question->chat_question_options as $chatquestion_option) {
                $abcd .= "<button type='button' class='btn btn-sm btn-default' onclick='question_second($chatquestion_option->id)'>"
                . $chatquestion_option->option .
                    "</button>
                                            <br>";
            }
            $chat_option = "<div class='rightside-details col pr-0'><div class='row m-0 pull-right'><div class='catag-name col pl-0'>" . $abcd . "</div></div></div>";
        } elseif ($chat_question == 'Image_Tag') {
            $abcd = "<img id='uploadPreview' style='width: 300px; height: 200px;' />
<input id='uploadImage' type='file' name='myPhoto' onchange='PreviewImage();' />
                                            <br>";
            $chat_option = "<div class='rightside-details col pr-0'><div class='row m-0 pull-right'><div class='catag-name col pl-0'>" . $abcd . "</div></div></div>";
        } elseif ($chat_question == 'Input_Tag') {
            foreach ($chat_question->chat_question_options as $chatquestion_option) {
                $abcd .= "<button type='button' class='btn btn-sm btn-default' onclick='question_fourth($chatquestion_option->id)'>"
                . $chatquestion_option->option .
                    "</button>
                                            <br>";
            }
            $chat_option = "<div class='rightside-details col pr-0'><div class='row m-0 pull-right'><div class='catag-name col pl-0'>" . $abcd . "</div></div></div>";
        } elseif ($chat_question == 'API') {
            $order_products = \App\OrderProduct::where('Order_Id', '=', $id)->get();
            foreach ($order_products as $order_product) {
                $abcd .= "<label for='quantity'>" . $order_product->Order_Id . "</label>
  <input type='number' name='quantity' value='" . $order_product->Order_Qty . "' min='1' max='5'>
                                            <br>";
            }
            $chat_option = "<div class='rightside-details col pr-0'><div class='row m-0 pull-right'><div class='catag-name col pl-0'>" . $abcd . "</div></div></div>";
        } else {
            foreach ($chat_question->chat_question_options as $chatquestion_option) {
                $abcd .= "<button type='button' class='btn btn-sm btn-default' onclick='question_fourth($chatquestion_option->id)'>"
                . $chatquestion_option->option .
                    "</button>
                                            <br>";
            }
            $chat_option = "<div class='rightside-details col pr-0'><div class='row m-0 pull-right'><div class='catag-name col pl-0'>" . $abcd . "</div></div></div>";
        }
        return response()->json(['status' => true, 'message' => 'Data Fetch Successfully', 'data' => $chat_question, 'options' => $chat_option], 200);
    }

    public function question_second_api(Request $request)
    {
        $abcd = "";
        $chat_option = "";
        $chat_question = \App\ChatQuestion::with('chat_question_options')->where('dependent_option_id', '=', $request->option_id)->first();

        foreach ($chat_question->chat_question_options as $chatquestion_option) {
            $abcd .= "<button type='button' class='btn btn-sm btn-default' onclick='question_fourth($chatquestion_option->id)'>"
            . $chatquestion_option->option .
                "</button>
                                            <br>";
        }
        $chat_option = "<div class='rightside-details col pr-0'><div class='row m-0 pull-right'><div class='catag-name col pl-0'>" . $abcd . "</div></div></div>";
        return response()->json(['status' => true, 'message' => 'Data Fetch Successfully', 'data' => $chat_question, 'options' => $chat_option], 200);
    }

    public function question_fourth_api(Request $request)
    {
        $abcd = "";
        $chat_question = \App\ChatQuestion::with('chat_question_options')->where('dependent_option_id', '=', $request->option_id)->first();
        // $chat_question = "Before proceeding ahead, please upload photo of the wrong items you have received in your order.<br> this helps to us to share feedback with our Dipo partner.";
        foreach ($chat_question->chat_question_options as $chatquestion_option) {

        }
        $abcd = "<img id='uploadPreview' style='width: 300px; height: 200px;' />
<input id='uploadImage' type='file' name='myPhoto' onchange='PreviewImage();' />
                                            <br>";

        $chat_option = "<div class='rightside-details col pr-0'><div class='row m-0 pull-right'><div class='catag-name col pl-0'>" . $abcd . "</div></div></div>";
        return response()->json(['status' => true, 'message' => 'Data Fetch Successfully', 'data' => $chat_question, 'options' => $chat_option], 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function chatApiApp()
    {
        $chat_question = \App\ChatQuestion::with('chat_question_options')->where('question_type', '=', 'single')->first();
        foreach ($chat_question->chat_question_options as $chat_question_option) {
            $question = \App\ChatQuestion::with('chat_question_options')->where('dependent_option_id', '=', $chat_question_option->id)->first();
            $chat_question_option->chat_question = $question;
        }
        if ($chat_question) {
            return response()->json(['status' => true, 'message' => 'Data Fetch Successfully', 'data' => $chat_question], 200);
        }
    }

    public function show($id)
    {
        $category = \App\Category::find($id);
        if ($category) {
            return view('backend.categories.show', compact('category'));
        }
        return redirect()->route('backend.categories.index');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id)
    {

        $groups = \App\Group::all();
        $category = \App\Category::find($id);

        if ($category) {
            return view('backend.categories.edit', compact('category', 'groups'));
        }
        return redirect()->route('backend.categories.index');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'name' => 'required',
            'group_id' => 'required',
        ]);
        $category = $this->category->find($id);
        $category->name = $request->input('name');
        $category->save();
        return redirect()->route('backend.categories.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
        $category = $this->category->find($id);
        if ($category->count()) {
            $category->delete();
            session()->flash('success', 'Selected Category deleted successfully.');
            return redirect()->route('backend.categories.index');
        }
        session()->flash('error', 'Selected Category dose not found in database please try after some time.');
        return redirect()->route('backend.categories.index');
    }

}