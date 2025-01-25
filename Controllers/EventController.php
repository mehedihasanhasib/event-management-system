<?php

namespace Controllers;

use Helpers\File;
use Models\Event;
use Core\Validator;
use Core\Controller;
use Core\Http\Request;

class EventController extends Controller
{
    public function index()
    {
        return $this->view('events.index');
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
            'banner' => ['required', 'image', 'mimes:jpg,jpeg,png,webp', 'size:5120'],
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
            dd($th->getMessage());
            return json_response(['status' => false, 'message' => 'Failed to create event'], 500);
        }
    }
}
