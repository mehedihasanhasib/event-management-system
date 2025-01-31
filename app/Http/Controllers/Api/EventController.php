<?php

namespace App\Http\Controllers\Api;

use App\Core\Controller;
use App\Helpers\DB;
use App\Http\Request;
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

    public function show(Request $request, $id)
    {
        $event = DB::query(
            "SELECT
                events.*,
                users.name AS organizer_name,
                users.email AS organizer_email,
                locations.name AS event_location,
                COUNT(attendees.id) AS total_attendees
            FROM
                events
            JOIN
                users ON users.id = events.user_id
            JOIN
                locations ON locations.id = events.location_id
            JOIN
                attendees ON attendees.event_id = events.id
            WHERE
                events.id = :id",
            [
                'id' => $id
            ]
        );

        return json_response([
            'data' => $event
        ]);
    }
}
