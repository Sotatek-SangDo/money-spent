<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Consts;
use App\Spend;
use Auth;
use Carbon\Carbon;
use Log;
use DB;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->month = Carbon::now()->month;
        $this->year = Carbon::now()->year;
        $this->startOfWeek = Carbon::now()->startOfWeek();
        $this->endOfWeek = Carbon::now()->endOfWeek();
        $this->startOfMonth = Carbon::now()->startOfMonth();
        $this->endOfMonth = Carbon::now()->endOfMonth();
        $this->startOfYear = Carbon::now()->startOfYear();
        $this->endOfYear = Carbon::now()->endOfYear();
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $input = $request->all();
        $limit = (isset($input['limit'])) ? $input['limit'] : Consts::DEFAULT_LIMIT;
        $time = (isset($input['time'])) ? $input['time'] :Consts::DEFAULT_TIME;
        $query = Spend::where('user_id', Auth()->user()->id);
        $month = (isset($input['month'])) ? $input['month'] : $this->month;
        if(!isset($input['month']) || $input['month'] == $this->month) {
            switch ($time) {
                case Consts::DEFAULT_TIME:
                    $query = $query->whereBetween('date_spend', [$this->startOfWeek, $this->endOfWeek]);
                    break;
                case Consts::TIME_MONTH:
                    $query = $query->whereBetween('date_spend', [$this->startOfMonth, $this->endOfMonth]);
                    break;
                default:
                    $query = $query->whereBetween('date_spend', [$this->startOfYear, $this->endOfYear]);
                    break;
            }
        } else {
             $query = $query->where(DB::raw("EXTRACT(MONTH FROM date_spend)"), $month)
                            ->where(DB::raw("EXTRACT(YEAR FROM date_spend)"), $this->year);
        }

        $spends = $query->paginate($limit);
        return view('spend.index', ['time' => $time, 'limit' => $limit, 'spends' => $spends, 'month' => $month]);
    }
}
