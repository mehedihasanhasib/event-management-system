<?php

namespace App\Http\Controllers;

use App\Core\Validator;
use App\Core\Controller;
use App\Helpers\DB;
use App\Http\Request;
use App\Models\Attendee;
use App\Models\Event;
use App\Models\Location;

class AttendeeController extends Controller
{
    public function index(Request $request, $id)
    {
        // dd($_SERVER);
        $exportCSV = $request->input('export') ?? false;
        $data = $this->getData($request, $id);

        if ($exportCSV) {
            $this->exportCSV($data['attendees']);
        }

        return $this->view('attendees.index', $data);
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
            $events = new Event();

            $total_attendees = $attendee->where('event_id', "=", 17)->count();
            $total_capacity = $events->where('id', "=", $request->input('event_id'))->get(['capacity']);

            if ($total_attendees >= $total_capacity) {
                return json_response(['status' => false, 'errors' => "Event is full"]);
            }

            $attendee->create([
                'event_id' => $request->input('event_id'),
                'name' => $request->input('name'),
                'email' => $request->input('email'),
                'phone_number' => $request->input('phone_number'),
                'location_id' => $request->input('location'),
            ]);

            return json_response(['status' => true, 'message' => 'Registration successful'], 201);
        } catch (\Throwable $th) {
            // return json_response(['status' => false, 'errors' => $th->getMessage()], 500);
            return json_response(['status' => false, 'errors' => "Registration Failed, Try Again!"], 500);
        }
    }

    public function getData($request, $id)
    {
        $attendee_name = $request->input('name') ?? null;
        $attendee_location = $request->input('location') ?? null;
        $attendee_phone = $request->input('phone') ?? null;

        $query = "SELECT 
                attendees.*,
                locations.name AS location_name
            FROM
                attendees 
            JOIN
                events ON events.id = attendees.event_id 
            JOIN
                locations ON attendees.location_id = locations.id
            WHERE 
                attendees.event_id = :event_id AND events.user_id = :user_id";

        $bindings = [
            'event_id' => $id,
            'user_id' => auth()['id']
        ];

        if ($attendee_name) {
            $query .= " AND attendees.name LIKE :name";
            $bindings['name'] = '%' . $attendee_name . '%';
        }

        if ($attendee_location) {
            $query .= " AND attendees.location_id = :location_id";
            $bindings['location_id'] = $attendee_location;
        }

        if ($attendee_phone) {
            $query .= " AND attendees.phone_number = :phone";
            $bindings['phone'] = $attendee_phone;
        }

        $attendees = DB::query($query, $bindings);

        $event = DB::query(
            "SELECT
                events.id,
                events.title,
                events.date,
                locations.name AS event_location
            FROM
                events
            JOIN
                locations ON events.location_id = locations.id
            WHERE
                events.id = :event_id
            LIMIT 1",
            [
                'event_id' => $id,
            ]
        );

        $location = new Location();
        $locations = $location->orderBy('id', 'asc')->get();

        return ['attendees' => $attendees, 'event' => $event, 'locations' => $locations];
    }

    public function exportCSV($attendees)
    {
        header('Content-Type: text/csv; charset=utf-8');
        header('Content-Disposition: attachment; filename=attendees.csv');

        $output = fopen('php://output', 'w');

        fputcsv($output, ["ID", "Name", "Email", "Number", "Location"]);

        $data = $attendees;

        foreach ($data as $key => $row) {
            fputcsv($output, [
                $key + 1,
                $row['name'],
                $row['email'],
                $row['phone_number'],
                $row['location_name'],
            ]);
        }

        fclose($output);
        exit;
    }
}
