<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Userloginlog;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class UserloginlogController extends Controller
{
    protected $user_login_log;

    public function __construct(Userloginlog $user_login_log)
    {
        $this->user_login_log = $user_login_log;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index(Request $request)
    {
        $date = $request->date;
        $login_for = $request->login_for;
        if ($date && ($login_for == 'User' || $login_for == 'Chemist' || $login_for == 'admin')) {
            $user_login_logs = \App\Userloginlog::where('user_role', '=', $login_for)->whereBetween('login_date_time', [$date . ' 00:00:00', $date . ' 23:59:59'])->get();
        } elseif ($date && $login_for == 'All') {
            $user_login_logs = \App\Userloginlog::whereBetween('login_date_time', [$date . ' 00:00:00', $date . ' 23:59:59'])->get();
        } elseif ($date) {
            $user_login_logs = \App\Userloginlog::whereBetween('login_date_time', [$date . ' 00:00:00', $date . ' 23:59:59'])->get();
        } else {
            $date = date('Y-m-d');
            $login_for = 'All';
            $user_login_logs = \App\Userloginlog::whereBetween('login_date_time', [$date . ' 00:00:00', $date . ' 23:59:59'])->get();
        }

        return view('backend.user_login_logs.index', compact('user_login_logs', 'login_for', 'date'));
    }

    public function registered_user_list(Request $request)
    {
        $states = \App\State::all();
        $start_date = $request->start_date;
        $end_date = $request->end_date;
        $registered_for = $request->registered_for;
        $user_for = $request->user_for;
        $state_code = $request->state_code;
        if ($state_code) {
            if ($user_for) {
                if ($start_date && $end_date && ($registered_for == 'User' || $registered_for == 'Chemist' || $registered_for == 'Admin')) {
                    $users = \App\User::where('users.status', 'verify')->where('users.role', '=', $registered_for)->whereBetween('users.created_at', [$start_date . ' 00:00:00', $end_date . ' 23:59:59'])
                        ->where('ApprovalSatus_Code', $user_for)->join('chemists as chemist', 'chemist.user_id', '=', 'users.id')
                        ->where('chemist.State_Code', '=', $state_code)
                        ->select('users.*')
                        ->with('chemists')
                        ->get();
                } elseif ($start_date && $end_date && $registered_for == 'All') {
                    $users = \App\User::where('users.status', 'verify')->whereBetween('users.created_at', [$start_date . ' 00:00:00', $end_date . ' 23:59:59'])
                        ->where('users.ApprovalSatus_Code', $user_for)->join('chemists as chemist', 'chemist.user_id', '=', 'users.id')
                        ->where('chemist.State_Code', '=', $state_code)
                        ->select('users.*')
                        ->with('chemists')
                        ->get();
                } elseif ($start_date && $end_date) {
                    $users = \App\User::where('users.status', 'verify')->whereBetween('users.created_at', [$start_date . ' 00:00:00', $end_date . ' 23:59:59'])
                        ->where('ApprovalSatus_Code', $user_for)->join('chemists as chemist', 'chemist.user_id', '=', 'users.id')
                        ->where('chemist.State_Code', '=', $state_code)
                        ->select('users.*')
                        ->with('chemists')
                        ->get();
                } else {
                    $start_date = date('Y-m-d');
                    $end_date = date('Y-m-d');
                    $registered_for = 'All';

                    $users = \App\User::where('users.status', 'verify')->whereBetween('users.created_at', [$start_date . ' 00:00:00', $end_date . ' 23:59:59'])
                        ->where('ApprovalSatus_Code', $user_for)->join('chemists as chemist', 'chemist.user_id', '=', 'users.id')
                        ->where('chemist.State_Code', '=', $state_code)
                        ->select('users.*')
                        ->with('chemists')
                        ->get();
                }
            } else {
                if ($start_date && $end_date && ($registered_for == 'User' || $registered_for == 'Chemist' || $registered_for == 'Admin')) {
                    $users = \App\User::where('users.status', 'verify')->where('users.role', '=', $registered_for)->whereBetween('users.created_at', [$start_date . ' 00:00:00', $end_date . ' 23:59:59'])
                        ->join('chemists as chemist', 'chemist.user_id', '=', 'users.id')
                        ->where('chemist.State_Code', '=', $state_code)
                        ->select('users.*')
                        ->with('chemists')
                        ->get();
                } elseif ($start_date && $end_date && $registered_for == 'All') {
                    $users = \App\User::where('users.status', 'verify')->whereBetween('users.created_at', [$start_date . ' 00:00:00', $end_date . ' 23:59:59'])->join('chemists as chemist', 'chemist.user_id', '=', 'users.id')
                        ->where('chemist.State_Code', '=', $state_code)
                        ->select('users.*')
                        ->with('chemists')
                        ->get();
                } elseif ($start_date && $end_date) {
                    $users = \App\User::where('users.status', 'verify')->whereBetween('users.created_at', [$start_date . ' 00:00:00', $end_date . ' 23:59:59'])->join('chemists as chemist', 'chemist.user_id', '=', 'users.id')
                        ->where('chemist.State_Code', '=', $state_code)
                        ->select('users.*')
                        ->with('chemists')
                        ->get();
                } else {
                    $start_date = date('Y-m-d');
                    $end_date = date('Y-m-d');
                    $registered_for = 'All';

                    $users = \App\User::where('status', 'verify')->whereBetween('created_at', [$start_date . ' 00:00:00', $end_date . ' 23:59:59'])
                        ->get();
                }
            }
        } else {
            if ($user_for) {
                if ($start_date && $end_date && ($registered_for == 'User' || $registered_for == 'Chemist' || $registered_for == 'Admin')) {
                    $users = \App\User::where('users.status', 'verify')->where('users.role', '=', $registered_for)->whereBetween('users.created_at', [$start_date . ' 00:00:00', $end_date . ' 23:59:59'])
                        ->where('ApprovalSatus_Code', $user_for)
                        ->get();
                } elseif ($start_date && $end_date && $registered_for == 'All') {
                    $users = \App\User::where('users.status', 'verify')->whereBetween('users.created_at', [$start_date . ' 00:00:00', $end_date . ' 23:59:59'])
                        ->where('users.ApprovalSatus_Code', $user_for)
                        ->get();
                } elseif ($start_date && $end_date) {
                    $users = \App\User::where('users.status', 'verify')->whereBetween('users.created_at', [$start_date . ' 00:00:00', $end_date . ' 23:59:59'])
                        ->where('ApprovalSatus_Code', $user_for)
                        ->get();
                } else {
                    $start_date = date('Y-m-d');
                    $end_date = date('Y-m-d');
                    $registered_for = 'All';

                    $users = \App\User::where('users.status', 'verify')->whereBetween('users.created_at', [$start_date . ' 00:00:00', $end_date . ' 23:59:59'])
                        ->where('ApprovalSatus_Code', $user_for)
                        ->get();
                }

            } else {

                if ($start_date && $end_date && ($registered_for == 'User' || $registered_for == 'Chemist' || $registered_for == 'Admin')) {

                    $users = \App\User::where('users.status', 'verify')->where('users.role', '=', $registered_for)->whereBetween('users.created_at', [$start_date . ' 00:00:00', $end_date . ' 23:59:59'])
                        ->get();
                } elseif ($start_date && $end_date && $registered_for == 'All') {
                    $users = \App\User::where('users.status', 'verify')->whereBetween('users.created_at', [$start_date . ' 00:00:00', $end_date . ' 23:59:59'])
                        ->get();
                } elseif ($start_date && $end_date) {
                    $users = \App\User::where('users.status', 'verify')->whereBetween('users.created_at', [$start_date . ' 00:00:00', $end_date . ' 23:59:59'])
                        ->get();
                } else {
                    $start_date = date('Y-m-d');
                    $end_date = date('Y-m-d');
                    $registered_for = 'All';

                    $users = \App\User::where('status', 'verify')->whereBetween('created_at', [$start_date . ' 00:00:00', $end_date . ' 23:59:59'])
                        ->get();
                }
            }
        }

        return view('backend.user_login_logs.registered_user_list', compact('users', 'registered_for', 'start_date', 'end_date', 'user_for', 'state_code', 'states'));
    }

    public function testing_user_list(Request $request)
    {
        $mobile = $request->mobile;
        if ($mobile) {
            $users = \App\User::where('mobile', $mobile)
                ->where('ApprovalSatus_Code', 3)
                ->get();
        } else {
            $users = \App\User::where('ApprovalSatus_Code', 3)
                ->get();
        }
        return view('backend.user_login_logs.testing_user_list', compact('users', 'mobile'));
    }

    public function change_user($id)
    {
        $user = \App\User::find($id);
        if ($user->ApprovalSatus_Code == 3) {
            $user->ApprovalSatus_Code = 1;
        } else {
            $user->ApprovalSatus_Code = 3;
        }
        $user->save();
        return redirect()->back();
    }

    public function change_into_testing(Request $request)
    {
        $user = \App\User::where('mobile', $request->mobile)->first();
        $user->ApprovalSatus_Code = 3;
        $user->save();
        return redirect()->back();
    }

    public function indexApp()
    {
        $user_login_logs = \App\Userloginlog::all();
        if ($user_login_logs) {
            echo json_encode($user_login_logs);
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
        return view('backend.user_login_logs.create');
    }

    public function user_add_to_card_but_shop()
    {
        $add_to_cart_user_list = \App\Addtocard::select('user_id')->distinct()->get();
        $data['users'] = \App\User::whereIn('id', $add_to_cart_user_list->map(function ($user) {
            return $user->user_id;
        }))->get();
        return view('backend.user_login_logs.user_add_to_card_but_shop', $data);
    }

    public function view_chemist_cart_detail($id)
    {
        $data['users'] = \App\User::find($id);
        $data['add_to_carts'] = \App\Addtocard::where('user_id', $id)->get();
        return view('backend.user_login_logs.view_chemist_cart_detail', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
        ]);
        $group = \App\Userloginlog::create([
            'name' => $request->input('name'),
        ]);
        if ($request->file('image')) {
            $image = $request->file('image');
            $filename = $image->getClientOriginalName();
            $fullname = Str::slug(Str::random(16) . $filename) . '.' . $image->getClientOriginalExtension();
            $image->move("upload", $fullname);
            $group->image = 'upload/' . $fullname;
        }
        $group->save();
        session()->flash('success', 'New Group is create Successfully');
        return redirect()->route('backend.user_login_logs.index');
    }

    public function storeApp(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
        ]);
        $group = \App\Userloginlog::create([
            'name' => $request->input('name'),
        ]);
        if ($group) {
            echo json_encode($group);
        } else {
            echo json_encode('Data Does Not Match. Please Try Again');
        }

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id)
    {
        $group = \App\Userloginlog::find($id);

        if ($group) {
            return view('backend.user_login_logs.show', compact('category'));
        }
        return redirect()->route('backend.user_login_logs.index');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id)
    {

        $group = \App\Userloginlog::find($id);

        if ($group) {
            return view('backend.user_login_logs.edit', compact('group'));
        }
        return redirect()->route('backend.user_login_logs.index');
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
        ]);

        $group = $this->group->find($id);
        $group->name = $request->input('name');
        if ($request->file('image')) {
            $image = $request->file('image');
            $filename = $image->getClientOriginalName();
            $fullname = Str::slug(Str::random(16) . $filename) . '.' . $image->getClientOriginalExtension();
            $image->move("upload", $fullname);
            $group->image = 'upload/' . $fullname;
        }
        $group->save();
        return redirect()->route('backend.user_login_logs.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
        $group = $this->group->find($id);
        if ($group->count()) {
            $group->delete();
            session()->flash('success', 'Selected Group deleted successfully.');
            return redirect()->route('backend.user_login_logs.index');
        }
        session()->flash('error', 'Selected Group dose not found in database please try after some time.');
        return redirect()->route('backend.user_login_logs.index');
    }

}