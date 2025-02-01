<?php

namespace App\Http\Controllers;

use App\Core\Auth;
use App\Helpers\DB;
use App\Helpers\File;
use App\Core\Validator;
use App\Core\Controller;
use App\Core\Session;
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

        return $this->view('events.index', ['events' => $events]);
    }

    public function create()
    {
        $locations = DB::query("SELECT * FROM locations ORDER BY name ASC");
        return $this->view('events.create', ['locations' => $locations]);
    }

    // event create
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), $this->validation_rules());


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

    // event edit page show
    public function edit(Request $request, $id)
    {
        $event_id = $id;
        $user_id = auth()['id'];
        $events = DB::query(
            'SELECT
                events.*,
                locations.name
            FROM
                events
            JOIN
                locations ON events.location_id = locations.id
            WHERE
                events.id = :event_id AND user_id = :user_id
            LIMIT 1',
            [
                'event_id' => $event_id,
                'user_id' => $user_id
            ]
        );

        if (!$events) {
            http_response_code(403);
            require_once "../views/403.php";
            exit;
        }

        $locations = DB::query("SELECT * FROM locations ORDER BY name ASC");
        return $this->view('events.edit', ['event' => $events, 'locations' => $locations]);
    }

    // event update
    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), $this->validation_rules([
            'banner' => ['image', 'mimes:jpg,jpeg,png,webp', 'size:2048'],
            'event_slug' => ['required', 'string', 'max:255']
        ]));


        if ($validator->fails()) {
            return json_response(['errors' => $validator->errors()], 422);
        }

        try {
            $event = new Event();
            $old_event = $event->find($request->input('id'));

            // dd($old_event);

            if ($old_event['user_id'] !== auth()['id']) {
                return json_response(['errors' => 'You do not have permission to edit this event'], 403);
            }

            if ($request->hasFile('banner')) {
                File::delete($old_event['banner']);

                $file = $request->file('banner');
                $path = DEFAULT_BANNER_UPLOAD_PATH;
                $image = File::upload($file, $path);
            }


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


            return json_response(['status' => true, 'message' => 'Event updated successfully'], 200);
        } catch (\Throwable $th) {
            return json_response(['status' => false, 'errors' => 'Failed to update event'], 500);
        }
    }

    public function destroy(Request $request, $id)
    {
        try {
            $deleted_event = DB::query("DELETE FROM events WHERE id = :id AND user_id = :user_id", [
                'id' => $id,
                'user_id' => auth()['id']
            ]);
            if (!$deleted_event) {
                Session::flash('status', false);
                Session::flash('message', 'Event delete failed, Try again!');
                return redirect(route('creator.events'));
            }
            Session::flash('status', true);
            Session::flash('message', 'Event deleted successfully');
            return redirect(route('creator.events'));
        } catch (\Throwable $th) {
            Session::flash('status', false);
            Session::flash('message', 'Event delete failed, Try again!');
            // Session::flash('message', $th->getMessage());
            return redirect(route('creator.events'));
        }
    }

    public function validation_rules($new_rule = [])
    {
        $rules = [
            'event_title' => ['required', 'string', 'max:255'],
            'event_slug' => ['required', 'string', 'max:255', 'unique:events,slug'],
            'event_description' => ['required', 'string', 'max:2000'],
            'event_date' => ['required', function ($value, $field, $fail) {
                $startDate = strtotime(date('Y-m-d', strtotime($value)));
                $currentDate = strtotime(date('Y-m-d'));
                if ($startDate < $currentDate) {
                    $fail("Event Date must be in the future.");
                };
            }],
            'event_time' => ['required'],
            'location' => ['required'],
            'max_capacity' => ['required', 'numeric'],
            'banner' => ['required', 'image', 'mimes:jpg,jpeg,png,webp', 'size:2048'],
        ];
        
        if (!empty($new_rule)) {
            $rules = array_merge($rules, $new_rule);
        }

        return $rules;
    }
}
