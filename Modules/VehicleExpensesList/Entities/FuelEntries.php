<?php

namespace Modules\VehicleExpensesList\Entities;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class FuelEntries extends Model
{
    protected $fillable = ['vehicle_id', 'entry_date', 'volume', 'cost'];

    protected $appends = array('type');

    public function vehicles()
    {
        return $this->hasOne(Vehicles::class, 'id', 'vehicle_id');
    }


    public function getTypeAttribute()
    {
        return "fuel";
    }

    public function getEntryDateAttribute($date)
    {
        return Carbon::createFromFormat('Y-m-d H:i:s', $date)->format('Y-m-d');
    }
}
