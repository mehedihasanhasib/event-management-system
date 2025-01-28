<?php

namespace App\Http\Controllers;

use App\Helpers\DB;
use App\Core\Controller;
use App\Http\Request;
use App\Models\Event;


class EventUserController extends Controller
{

    protected $locations;

    public function __construct()
    {
        $this->locations = DB::query("SELECT * FROM locations ORDER BY name ASC");
    }

    public function index(Request $request)
    {
        try {
            $event = new Event();

            $events = $event->when($request->has('title'), function ($query) use ($request) {

                return $query->whereLike('title', $request->input('title')); // search by title

            })->when($request->has('location'), function ($query) use ($request) {

                return $query->where('location_id', "=", $request->input('location')); // search by location

            })->when($request->has('date_from') && $request->has('date_to'), function ($query) use ($request) {

                return $query->whereBetween('date', [$request->input('date_from'), $request->input('date_to')]); // search by date

            })->orderBy('id', 'desc')->paginate(3);

            return $this->view('events.user.index', ['events' => $events, 'locations' => $this->locations]);
        } catch (\Throwable $th) {
            die($th->getMessage());
        }
    }

    public function show(Request $request)
    {
        if (!$request->has('slug')) {
            return redirect(route('events'));
        }

        try {
            $event = DB::query(
                "SELECT events.*, 
                users.name AS organizer_name,
                users.email AS organizer_email,
                users.profile_picture AS organizer_profile_picture,
                locations.name AS location_name,
                COUNT(attendees.id) AS total_attendees
            FROM 
                events
            JOIN
                users ON events.user_id = users.id
            JOIN
                locations ON events.location_id = locations.id
            LEFT JOIN
                attendees ON events.id = attendees.event_id
            WHERE
                events.slug = :slug
            LIMIT 1",
                [
                    'slug' => $request->input('slug')
                ]
            );

            $this->view('events.user.show', ['event' => $event[0], 'locations' => $this->locations]);
        } catch (\Throwable $th) {
            die($th->getMessage());
        }
    }
}
