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
        $limit = Consts::DEFAULT_LIMIT;
        $time = (isset($input['time'])) ? $input['time'] :Consts::DEFAULT_TIME;
        $query = Spend::where('user_id', Auth()->user()->id);
        $month = (isset($input['month'])) ? $input['month'] : $this->month;
        $start_date = (isset($input['date_start'])) ? $input['date_start'] : '';
        $end_date = (isset($input['date_end'])) ? $input['date_end'] : '';
        if($start_date || $end_date) {
            if($start_date && !$end_date)
                $query = $query->where('date_spend', '>=', $start_date);
            else if(!$start_date && $end_date)
                $query = $query->where('date_spend', '<=', $end_date);
            else
                $query = $query->whereBetween('date_spend',[$start_date, $end_date]);
        } else if(!isset($input['month']) || $input['month'] == $this->month) {
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
        return view('spend.index', [
                'time' => $time,
                'limit' => $limit,
                'spends' => $spends,
                'month' => $month,
                'start_date' => $start_date,
                'end_date' => $end_date
            ]);
    }

    public function home()
    {
        return view('home');
    }
}
