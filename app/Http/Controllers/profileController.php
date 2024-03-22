<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\profile;
class profileController extends Controller
{
   public function infoUser()
   {

return response()->json(new profile(Auth::user()));
   }
}
