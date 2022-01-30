<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ParkingLotTilesResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $slot_details = null;
        $slot = $this->slot_details;

        if($slot){

            $slot_details = [
                'size' => $slot->slot_type->vehicle_size,
                'rate' => $slot->slot_type->rate,
                'is_occupied' => $slot->is_occupied,
                'transactions' => $slot->transaction
            ];
        }

        return [
            'id' => $this->id,
            // 'entrance_distance' => $this->entrance_distance,
            'is_obstacle' => $this->is_obstacle,
            'is_open_space' => $this->is_open_space,
            'is_parking_space' => $this->is_parking_space,
            'can_be_entrance' => $this->can_be_entrance,
            'is_entrance' => !!$this->entrance_details,
            'entrance_details' => $this->entrance_details ?? null,
            'slot_details' => $slot ? $slot_details : null
        ];
    }
}
