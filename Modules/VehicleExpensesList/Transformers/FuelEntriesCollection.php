<?php

namespace Modules\VehicleExpensesList\Transformers;

use Illuminate\Http\Resources\Json\ResourceCollection;

class FuelEntriesCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request
     * @return array
     */
    public function toArray($request)
    {
        return  FuelEntriesResource::collection($this->collection);
    }
}
