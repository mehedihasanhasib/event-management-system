<?php

namespace Controllers;

use Core\Auth;
use Helpers\File;
use Models\Event;
use Core\Database;
use Core\Validator;
use Core\Controller;
use Core\Http\Request;

class EventController extends Controller
{
    public function index()
    {
        $events = new Event();
        $events = $events->where('user_id', "=", auth()['id'])->get();
        return $this->view('events.index', ['events' => $events]);
    }

    public function create()
    {
        return $this->view('events.create');
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'event_title' => ['required', 'string', 'max:255'],
            'event_slug' => ['required', 'string', 'max:255'],
            'event_description' => ['required', 'string', 'max:1000'],
            'event_date' => ['required'],
            'event_time' => ['required'],
            'event_location' => ['required'],
            'max_capacity' => ['required'],
            'banner' => ['required', 'image', 'mimes:jpg,jpeg,png,webp', 'size:2048'],
        ]);


        if ($validator->fails()) {
            return json_response(['errors' => $validator->errors()], 422);
        }

        try {
            $event = new Event();
            if ($request->hasFile('banner')) {
                $file = $request->file('banner');
                $path = "uploads/banners/";
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
                'location' => $request->input('event_location'),
                'capacity' => $request->input('max_capacity'),
            ]);
            return json_response(['status' => true, 'message' => 'Event created successfully'], 201);
        } catch (\Throwable $th) {
            return json_response(['status' => false, 'errors' => 'Failed to create event'], 500);
        }
    }

    public function edit(Request $request)
    {
        if (!$request->has('id') || $request->input('id') == null) {
            return redirect(route('myevents'));
        }

        $id = $request->input('id');
        $event = new Event();
        $event = $event->find($id);
        if (Auth::authorize($event['user_id'])) {
            return $this->view('events.edit', ['event' => $event]);
        }
    }

    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'event_title' => ['required', 'string', 'max:255'],
            'event_slug' => ['required', 'string', 'max:255'],
            'event_description' => ['required', 'string', 'max:1000'],
            'event_date' => ['required'],
            'event_time' => ['required'],
            'event_location' => ['required'],
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
                $path = "uploads/banners/";
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
                    'location' => $request->input('event_location'),
                    'capacity' => $request->input('max_capacity'),
                ]);
            }

            return json_response(['status' => true, 'message' => 'Event updated successfully'], 200); //code...
        } catch (\Throwable $th) {
            return json_response(['status' => false, 'errors' => 'Failed to update event'], 500);
        }
    }

    public function events(Request $request)
    {
        // try {
            $event = new Event();

            $events = $event->when($request->has('date'), function ($query) use ($request) {
                return $query->where('date', "=", $request->input('date'));
            })->when($request->has('title'), function ($query) use ($request) {
                return $query->whereLike('title', $request->input('title'));
            })->when($request->has('location'), function ($query) use ($request) {
                return $query->where('location', "=", $request->input('location'));
            })->paginate(3);

            return $this->view('events.user.index', ['events' => $events]);
        // } catch (\Throwable $th) {
        //     die($th->getMessage());
        // }
    }
}
