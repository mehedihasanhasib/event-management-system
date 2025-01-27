<?php

namespace Controllers;

use Core\Validator;
use Core\Controller;
use Models\Attendee;
use Core\Http\Request;

class AttendeeController extends Controller
{
    public function index()
    {
        return $this->view('attendees.index');
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
