<?php

namespace Modules\VehicleExpensesList\Entities;

use Illuminate\Database\Eloquent\Model;

class Vehicles extends Model
{
    protected $fillable = ['id','name','plate_number','imei','vin','year','license'];

    public function fuel_entries()
    {
       return  $this->hasMany(FuelEntries::class,'vehicle_id','id');
    }


}
