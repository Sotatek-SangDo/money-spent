<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\UserRequest;
use App\User;
use Auth;
use App\Http\Services\SpendService;
use Hash;

class ParentsController extends Controller
{
    public function __construct(SpendService $spend)
    {
        $this->middleware('auth');
        $this->spendService = $spend;
    }

    public function index(Request $request)
    {
        $data = $this->spendService->getListSpend($request);
        $children = User::where('user_parents_id', Auth::user()->id)->get();
        return view('spend.index', [
            'time' => $data['time'],
            'limit' => $data['limit'],
            'spends' => $data['spends'],
            'month' => $data['month'],
            'start_date' => $data['start_date'],
            'end_date' => $data['end_date'],
            'url' => 'my-spend',
            'children' => $children,
            'user_child' => $data['user_child'],
            'url' => 'children'
        ]);
    }

    public function addAccount()
    {
        return view('child.index');
    }

    public function store(UserRequest $request)
    {
        $input = $request->all();
        $input['password'] = Hash::make($input['password']);
        User::create($input);
        return redirect()->route('spend_children');
    }
    public function getChildren()
    {
        return Auth::user()->children();
    }
}
