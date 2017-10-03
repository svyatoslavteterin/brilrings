<?php

namespace App\Http\Controllers;

use App\RingSession;

class RingSessionController extends Controller
{


    public function index(){

      $ring_sessions=RingSession::all();

      return $ring_sessions;
    }
}
