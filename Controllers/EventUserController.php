<?php

namespace Controllers;

use Helpers\DB;
use Models\Event;
use Core\Controller;
use Core\Http\Request;

class EventUserController extends Controller
{
    public function index(Request $request)
    {
        try {
            $event = new Event();

            $events = $event->when($request->has('title'), function ($query) use ($request) {
                return $query->whereLike('title', $request->input('title'));
            })->when($request->has('location'), function ($query) use ($request) {
                return $query->where('location_id', "=", $request->input('location'));
            })->when($request->has('date_from') && $request->has('date_to'), function ($query) use ($request) {
                return $query->whereBetween('date', [$request->input('date_from'), $request->input('date_to')]);
            })->orderBy('id', 'desc')->paginate(3);

            $locations = DB::query("SELECT * FROM locations ORDER BY name ASC");

            return $this->view('events.user.index', ['events' => $events, 'locations' => $locations]);
        } catch (\Throwable $th) {
            die($th->getMessage());
        }
    }
}
