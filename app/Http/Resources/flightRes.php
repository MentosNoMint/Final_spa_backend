<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class flightRes extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'flight_id' => $this->id,
            'flight_code' => $this->flight_code,
            'from' => [
                'city' => $this->airportFrom->city,
                'airport' => $this->airportFrom->name,
                'iata' => $this->airportFrom->iata,
                'date' => $this->date,
                'time' => $this->time_from,
            ],
            'to' => [
                'city' => $this->airportTo->city,
                'airport' => $this->airportTo->name,
                'iata' => $this->airportTo->iata,
                'date' => $this->date,
                'time' => $this->time_to,
            ],
            'cost' => $this->cost,
            'availability' => $this->getAvailabitilty(),
        ];
    }
}
