<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Spend extends Model
{
    public $table = 'spends';

    public $fillable =[
        'id',
        'title',
        'amount',
        'user_id',
        'date_spend'
    ];

    protected $casts = [
        'id'        => 'integer',
        'title'     => 'string',
        'amount'   => 'string',
        'user_id'  => 'integer',
        'date_spend'  => 'date'
    ];

    public static $rules = [
        'id'        => 'integer',
        'title'     => 'required|string',
        'amount'    => 'required|numeric',
        'date_spend'  => 'required|date',
        'user_id'   => 'required|exists:users,id'
    ];

    public function getDateSpendAttribute()
    {
        return Carbon::parse($this->attributes['date_spend'])->format('Y-m-d');
    }

    public function setDateSpendAttribute($value)
    {
        $this->attributes['date_spend'] = Carbon::parse($value)->format('Y-m-d');
    }

    public function getAmountAttribute()
    {
        return number_format($this->attributes['amount']);
    }

    public function setAmountAttribute($value)
    {
        $this->attributes['amount'] = $value;
    }
}
