<?php

namespace App\Http\Services;

use App\Spend;
use Illuminate\Http\Request;
use App\Consts;
use Carbon\Carbon;
use DB;
use Auth;
use Log;

class SpendService
{
    public function __construct()
    {
        $this->month = Carbon::now()->month;
        $this->year = Carbon::now()->year;
        $this->startOfWeek = Carbon::now()->startOfWeek();
        $this->endOfWeek = Carbon::now()->endOfWeek();
        $this->startOfMonth = Carbon::now()->startOfMonth();
        $this->endOfMonth = Carbon::now()->endOfMonth();
        $this->startOfYear = Carbon::now()->startOfYear();
        $this->endOfYear = Carbon::now()->endOfYear();
    }

    public function getListSpend($request, $userSpendId = null)
    {
        $currentUserId = Auth::user()->id;
        $input = $request->all();
        $limit = Consts::DEFAULT_LIMIT;
        $time = (isset($input['time'])) ? $input['time'] :Consts::DEFAULT_TIME;
        $month = (isset($input['month'])) ? $input['month'] : $this->month;
        $start_date = (isset($input['date_start'])) ? $input['date_start'] : '';
        $end_date = (isset($input['date_end'])) ? $input['date_end'] : '';
        $userChild = (isset($input['user_child_name'])) ? $input['user_child_name'] : '';
        $userSpendId = (isset($input['user_child_name'])) ? Auth()->user()->userIdByName($input['user_child_name'], $currentUserId) : $userSpendId;
        if(!$userSpendId) {
            return [
                'time' => $time,
                'limit' => $limit,
                'spends' => [],
                'month' => $month,
                'start_date' => $start_date,
                'end_date' => $end_date,
                'user_child' => $userChild
            ];
        }
        $query = Spend::where('user_id', $userSpendId);
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
        return [
                'time' => $time,
                'limit' => $limit,
                'spends' => $spends,
                'month' => $month,
                'start_date' => $start_date,
                'end_date' => $end_date,
                'user_child' => $userChild
            ];
    }
}
