<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\AddSpendRequest;
use App\Events\UserCreateSpend;
use App\Spend;
use Auth;
use App\Consts;
use Log;

class SpendController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'web']);
    }

    public function index()
    {
        return view('spend.add');
    }

    public function store(AddSpendRequest $request)
    {
        $input = $request->all();
        $spend = Spend::create($input);
        broadcast(new UserCreateSpend($spend));
        return redirect()->route('home');
    }

    public function live()
    {
        $spends = Spend::selectRaw('spends.id, spends.title, spends.user_id, users.name, spends.amount, spends.is_new')
                        ->join('users', 'users.id', '=', 'spends.user_id')
                        ->where('spends.is_new', Consts::IS_NEW)
                        ->where('users.user_parents_id', Auth::user()->id)
                        ->get();
        return [
            'user' => Auth::user(),
            'spend' => $spends
        ];
    }

    public function update($id)
    {
        $spend = Spend::find($id);
        $spend['is_new'] = 1;
        $spend->save();
        return [ 'mess' => 'success'];
    }
}
