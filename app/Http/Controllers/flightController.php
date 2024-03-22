<?php

namespace App\Http\Controllers;

use Facade\FlareClient\Flare;
use Illuminate\Http\Request;
use App\Http\Resources\flightRes;
use App\Models\flight;
use Illuminate\Support\Facades\Validator;

class flightController extends Controller
{


    public function getFlights($from , $to , $date)
    {
      $flights = flight::whereHas('airportFrom' , function ($q) use ($from) {
          $q->where('iata' , $from);
      })->whereHas('airportTo' , function ($q) use ($to) {
          $q->where('iata' , $to);
      })->get();

        $flights->map(function ($flight) use ($date) {
            $flight->setDate($date);
        });
        return $flights;
    }



    public function search(Request $request)
    {
        $validator = Validator::make($request->all() , [
            'from' => 'required|exists:airports,iata',
            'to' => 'required|exists:airports,iata',
            'date1' => 'required|date_format:Y-m-d',
            'date2' => 'date_format:Y-m-d',
            'passengers' => 'required|max:8|min:1'
        ]);

        if($validator->fails()){
            return response()->json([
                'error' => [
                    'code' => 422,
                    'message' => 'Validation error',
                    'errors' => $validator->errors()
                ]
            ], 422);
        }
        $flights = $this->getFlights($request['from'], $request['to'] , $request['date1']);

        if($request->has('date2')){
            $flightsBack = $this->getFlights($request['from'], $request['to'] , $request['date2']);
        }

        return response()->json([
            'data' => [
                'flights_to' => flightRes::collection($flights),
                'flights_back' => $request->has('date2') ? flightRes::collection($flightsBack) : []
            ]
        ]);
    }
}
