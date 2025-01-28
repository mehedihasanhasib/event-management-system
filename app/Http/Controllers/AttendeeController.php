<?php

namespace App\Http\Controllers;

use App\Core\Validator;
use App\Core\Controller;
use App\Helpers\DB;
use App\Http\Request;
use App\Models\Attendee;

class AttendeeController extends Controller
{
    public function index(Request $request, $id)
    {
        $attendees = DB::query(
            "SELECT 
                attendees.*,
                locations.name AS location_name
            FROM
                attendees 
            JOIN
                events ON events.id = attendees.event_id 
            JOIN
                locations ON attendees.location_id = locations.id
            WHERE 
                attendees.event_id = :event_id AND events.user_id = :user_id",
            [
                'event_id' => $id,
                'user_id' => auth()['id']
            ]
        );

        $event = DB::query(
            "SELECT 
                events.title,
                events.date,
                locations.name AS event_location
            FROM
                events
            JOIN
                locations ON events.location_id = locations.id
            WHERE
                events.id = :event_id",
            [
                'event_id' => $id,
            ]
        );

        return $this->view('attendees.index', ['attendees' => $attendees, 'event' => $event[0]]);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'event_id' => ['required', 'exists:events,id'],
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255'],
            'phone_number' => ['required', 'max:11'],
            'location' => ['required', 'exists:locations,id'],
        ]);

        if ($validator->fails()) {
            return json_response(['errors' => $validator->errors()], 422);
        }

        try {
            $attendee = new Attendee();

            $attendee->create([
                'event_id' => $request->input('event_id'),
                'name' => $request->input('name'),
                'email' => $request->input('email'),
                'phone_number' => $request->input('phone_number'),
                'location_id' => $request->input('location'),
            ]);

            return json_response(['status' => true, 'message' => 'Attendee created successfully'], 201);
        } catch (\Throwable $th) {
            // return json_response(['status' => false, 'errors' => $th->getMessage()], 500);
            return json_response(['status' => false, 'errors' => "An error occurred while creating attendee, Try Again!"], 500);
        }
    }
}
