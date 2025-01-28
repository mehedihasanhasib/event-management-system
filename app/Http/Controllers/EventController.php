<?php

namespace App\Http\Controllers;

use App\Core\Auth;
use App\Helpers\DB;
use App\Helpers\File;
use App\Core\Validator;
use App\Core\Controller;
use App\Http\Request;
use App\Models\Event;


class EventController extends Controller
{
    public function index()
    {
        $user_id = auth()['id'];
        $events = DB::query(
            "SELECT
                events.*,
                locations.name AS location_name,
                COUNT(attendees.id) AS total_attendees
            FROM
                events
            JOIN
                locations ON events.location_id = locations.id
            LEFT JOIN
                attendees ON events.id = attendees.event_id
            WHERE
                user_id = :user_id
            GROUP BY
                events.id, locations.name",
            [
                'user_id' => $user_id,
            ]
        );

        // return json_response($events);

        return $this->view('events.index', ['events' => $events]);
    }

    public function create()
    {
        $locations = DB::query("SELECT * FROM locations ORDER BY name ASC");
        return $this->view('events.create', ['locations' => $locations]);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'event_title' => ['required', 'string', 'max:255'],
            'event_slug' => ['required', 'string', 'max:255'],
            'event_description' => ['required', 'string', 'max:1000'],
            'event_date' => ['required'],
            'event_time' => ['required'],
            'location' => ['required'],
            'max_capacity' => ['required', 'numeric'],
            'banner' => ['required', 'image', 'mimes:jpg,jpeg,png,webp', 'size:2048'],
        ]);


        if ($validator->fails()) {
            return json_response(['errors' => $validator->errors()], 422);
        }

        try {
            $event = new Event();
            if ($request->hasFile('banner')) {
                $file = $request->file('banner');
                $path = DEFAULT_BANNER_UPLOAD_PATH;
                $image = File::upload($file, $path);
            }
            $slug = str_replace([" ", "_", "," . "."], "-", strtolower($request->input('event_slug')));
            $event->create([
                'user_id' => auth()['id'],
                'title' => $request->input('event_title'),
                'slug' => $slug,
                'description' => $request->input('event_description'),
                'banner' => $image,
                'date' => $request->input('event_date'),
                'time' => $request->input('event_time'),
                'location_id' => $request->input('location'),
                'capacity' => $request->input('max_capacity'),
            ]);
            return json_response(['status' => true, 'message' => 'Event created successfully'], 201);
        } catch (\Throwable $th) {
            return json_response(['status' => false, 'errors' => 'Failed to create event'], 500);
        }
    }

    public function edit(Request $request, $id)
    {
        $event_id = $id;
        $user_id = auth()['id'];
        $events = DB::query('SELECT events.*, locations.name FROM events JOIN locations ON events.location_id = locations.id WHERE events.id = :event_id AND user_id = :user_id', [
            'event_id' => $event_id,
            'user_id' => $user_id
        ]);
        $locations = DB::query("SELECT * FROM locations ORDER BY name ASC");
        return $this->view('events.edit', ['event' => $events[0], 'locations' => $locations]);
    }

    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'event_title' => ['required', 'string', 'max:255'],
            'event_slug' => ['required', 'string', 'max:255'],
            'event_description' => ['required', 'string', 'max:1000'],
            'event_date' => ['required'],
            'event_time' => ['required'],
            'location' => ['required'],
            'max_capacity' => ['required'],
            'banner' => ['image', 'mimes:jpg,jpeg,png,webp', 'size:2048'],
        ]);


        if ($validator->fails()) {
            return json_response(['errors' => $validator->errors()], 422);
        }

        try {
            $event = new Event();
            $old_event = $event->find($request->input('id'));

            if ($request->hasFile('banner')) {
                File::delete($old_event['banner']);

                $file = $request->file('banner');
                $path = DEFAULT_BANNER_UPLOAD_PATH;
                $image = File::upload($file, $path);
            }


            if (Auth::authorize($old_event['user_id'])) {
                $slug = str_replace([" ", "_", "," . "."], "-", strtolower($request->input('event_slug')));
                $event->update($old_event['id'], [
                    'title' => $request->input('event_title'),
                    'slug' => $slug,
                    'description' => $request->input('event_description'),
                    'banner' => $image ?? $old_event['banner'],
                    'date' => $request->input('event_date'),
                    'time' => $request->input('event_time'),
                    'location_id' => $request->input('location'),
                    'capacity' => $request->input('max_capacity'),
                ]);
            }

            return json_response(['status' => true, 'message' => 'Event updated successfully'], 200); //code...
        } catch (\Throwable $th) {
            return json_response(['status' => false, 'errors' => 'Failed to update event'], 500);
        }
    }
}
