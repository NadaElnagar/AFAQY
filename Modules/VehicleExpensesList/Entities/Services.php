<?php

namespace Modules\VehicleExpensesList\Entities;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Services extends Model
{
    protected $fillable = ['vehicle_id', 'total', 'created_at'];

    protected $appends = array('type');

    public function vehicles()
    {
        return $this->hasOne(Vehicles::class, 'id', 'vehicle_id');
    }

    public function getTypeAttribute()
    {
        return "services";
    }

    public function getCreatedAtAttribute($value)
    {
        return Carbon::parse($value)->format('Y-m-d');
    }
}
