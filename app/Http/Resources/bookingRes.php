<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class bookingRes extends JsonResource
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
            'code' => $this->code,
            'cost' => $this->getCost(),
            'flights' => flightRes::collection($this->flightBack ? collect([$this->flightFrom , $this->flightBack]) : $this->flightFrom),
            'passengers' => PassengerResource::collection($this->passengers)
        ];
    }
}
