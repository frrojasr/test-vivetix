<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Event;

class EventController extends Controller
{
    //


    public function list(Request $request)
    {
       $events= Event::all();
       return view('event', compact('events') );
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'date' => 'required|date',
            'description' => 'required|string',
            'tickets' => 'required|integer|min:1',
            'price_per_ticket' => 'required|numeric',
        ]);

        $event = new Event;
        $event->name = $request->input('name');
        $event->date = $request->input('date');
        $event->description = $request->input('description');
        $event->tickets = $request->input('tickets');
        $event->remaining_tickets = $request->input('tickets');
        $event->price_per_ticket = $request->input('price_per_ticket');
        
        

        $event->save();

        //$event->generateTickets();

        return redirect()->route('event.list')->with('success', 'Evento '. $event->name .' creado correctamente');
    }
}


