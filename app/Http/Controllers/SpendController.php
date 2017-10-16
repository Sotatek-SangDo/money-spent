<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\AddSpendRequest;
use App\Spend;

class SpendController extends Controller
{
    public function __contruct()
    {

    }

    public function index()
    {
        return view('spend.add');
    }

    public function store(AddSpendRequest $request)
    {
        $input = $request->all();
        Spend::create($input);
        return redirect()->route('home');
    }
}
