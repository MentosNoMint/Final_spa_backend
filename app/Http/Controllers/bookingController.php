<?php

namespace App\Http\Controllers;

use App\Http\Resources\bookingRes;
use App\Models\Booking;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use App\Models\Passenger;

class bookingController extends Controller
{
    public function booking(Request $request)
    {
        $validator = Validator::make($request->all() , [
            'flight_from.id' => 'required|exists:flights,id',
            'flight_back.id' => 'exists:flights,id',
            'flight_back.date' => 'date_format:Y-m-d',
            'flight_from.date' => 'required|date_format:Y-m-d',
            'passengers' => 'required',
            'passengers.*.first_name' => 'required',
            'passengers.*.last_name' => 'required',
            'passengers.*.birth_date' => 'required|date_format:Y-m-d',
            'passengers.*.document_number' => 'required|numeric|digits:10'
        ]);

        if ($validator->fails()){
            return response()->json([
                'error' => [
                    'code' => 422,
                    'message' => 'Validation error',
                    'errors' => [
                        $validator->errors()
                    ]
                ]
            ], 422);
        }

        $bookingData = [
            'flight_from' => $request['flight_from.id'],
            'date_from' => $request['flight_from.date'],
            'code' => Str::upper(Str::random(5))
        ];
        if ($request->has('flight_back')) {
            $bookingData['flight_back'] = $request['flight_back.id'];
            $bookingData['date_back'] = $request['flight_back.date'];
        }

        $booking = Booking::create($bookingData);
        $booking->passengers()->createMany($request['passengers']);

        return response()->json([
            'data' => [
                'code' => $booking->code
            ]
        ]);
    }

    public function bookingInfo($code)
    {
$booking = Booking::where('code' , $code)->first();

$booking->flightFrom->date = $booking->date_from;

if($booking->flightBack){
    $booking->flightBack->date = $booking->date_back;
}
return new bookingRes($booking);
    }

}
