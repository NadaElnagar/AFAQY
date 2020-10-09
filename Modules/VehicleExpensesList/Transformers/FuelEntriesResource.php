<?php

namespace Modules\VehicleExpensesList\Transformers;

use Illuminate\Http\Resources\Json\JsonResource;

class FuelEntriesResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->vehicles->id,
            'name' => $this->vehicles->name,
            'plate_number' => $this->vehicles->plate_number,
            'type' =>  $this->type,
            'cost'=>$this->cost,
            'created_at' => $this->entry_date
        ];
    }
}
