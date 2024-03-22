<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\search;
use App\Http\Resources\searchRes;
use Illuminate\Support\Facades\DB;
class searchController extends Controller
{
    public function airports(Request $request)
    {
        $query = $_GET['query'];

        $airports = DB::select("Select * from airports WHERE name LIKE '%${query}%' or iata like '%${query}%' or city like '%${query}%'");
        return response()->json([
            'data' => [
                'items' => searchRes::collection($airports)
            ]
        ]);
    }
}
