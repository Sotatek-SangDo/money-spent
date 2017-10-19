<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Consts;
use App\Spend;
use Auth;
use Carbon\Carbon;
use Log;
use DB;
use App\Http\Services\SpendService;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(SpendService $spend)
    {
        $this->middleware('auth');
        $this->spendService = $spend;
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $userId = Auth::user()->id;
        $data = $this->spendService->getListSpend($request, $userId);
        return view('spend.index', [
                'time' => $data['time'],
                'limit' => $data['limit'],
                'spends' => $data['spends'],
                'month' => $data['month'],
                'start_date' => $data['start_date'],
                'end_date' => $data['end_date'],
                'url' => 'my-spend'
            ]);
    }

    public function home()
    {
        return view('home');
    }
}
