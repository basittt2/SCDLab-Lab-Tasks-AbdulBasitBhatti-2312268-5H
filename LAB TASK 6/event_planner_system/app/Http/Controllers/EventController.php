<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class EventController extends Controller
{
    private $events = [
        [
            'name' => 'Gaming Expo 2025',
            'date' => '2025-11-15',
            'location' => 'Karachi',
            'status' => 'Upcoming',
            'description' => 'A fun expo for gamers.'
        ],
        [
            'name' => 'Tech Conference',
            'date' => '2025-10-20',
            'location' => 'Lahore',
            'status' => 'Ongoing',
            'description' => 'Latest technology updates.'
        ],
        [
            'name' => 'Music Fest',
            'date' => '2025-09-10',
            'location' => 'Islamabad',
            'status' => 'Completed',
            'description' => 'A musical extravaganza.'
        ]
    ];

    // Display all events
    public function index()
    {
        return view('events', ['events' => $this->events]);
    }

    // Show details of one event
    public function details($id)
    {
        if (!isset($this->events[$id])) {
            return "Event not found";
        }
        return view('details', ['event' => $this->events[$id]]);
    }

    // Show create form
    public function create()
    {
        return view('create');
    }

    // Handle form submission
    public function store(Request $request)
    {
        $data = $request->all();

        if (empty($data['name']) || empty($data['date']) || empty($data['location']) || empty($data['description'])) {
            return "Please fill all fields";
        }

        return view('response', ['event' => $data]);
    }
}
