<?php

namespace App\Http\Controllers;

use App\Core\Controller;
use App\Core\Database;

class HomeController extends Controller
{
    public function index()
    {
        $events = Database::query(
            'SELECT
                title,
                slug,
                description,
                date,
                banner,
                COUNT(attendees.id) as total_attendee
            FROM
                events
            JOIN
                attendees ON attendees.event_id = events.id
            WHERE
                events.date >= NOW()
            GROUP BY
                events.id
            ORDER BY
                total_attendee DESC
            LIMIT 3'
        );

        return $this->view('home.index', ['events' => $events]);
    }
}
