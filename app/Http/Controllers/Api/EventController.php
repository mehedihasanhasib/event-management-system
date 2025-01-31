<?php

namespace App\Http\Controllers\Api;

use App\Core\Controller;
use App\Models\Event;

class EventController extends Controller
{
    public function index()
    {
        $events = new Event();

        $all_events = $events->all();

        return json_response([
            'data' => $all_events
        ], 200);
    }
}
