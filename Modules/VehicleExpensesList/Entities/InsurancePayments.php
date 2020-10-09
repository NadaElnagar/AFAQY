<?php

namespace Modules\VehicleExpensesList\Entities;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class InsurancePayments extends Model
{
    protected $fillable = ['vehicle_id','contract_date','expiration_date','amount'];

    protected $appends = array('type');

    public function vehicles()
    {
        return $this->hasOne(Vehicles::class, 'id', 'vehicle_id');
    }

    public function getTypeAttribute()
    {
        return "insurance";
    }
}
