<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\Request;
use App\Models\Sale;

class SaleController extends Controller
{
    //
    public function index(Request $request)
    {
        $sales = Sale::all();
        $events = Event::all();
        return view('sales', compact('sales', 'events'));
    }


    public function store(Request $request)
    {
        $request->validate([

            'event_id' => 'required|integer',
            'qty_tickets' => 'required|integer|min:1',
            'client_name' => 'required|string|max:255',
            'client_dni' => 'required|string|max:20',
            'client_phone' => 'required|string|max:20',
            'voucher' => 'required|file|mimes:jpg,pdf|max:2048',
            'date' => 'required|date',
        ]);


        try {
            $event = Event::where('id', $request->event_id)->first();

          

            if ($request->qty_tickets <= $event->remaining_tickets) {
                $sale = new Sale();
                $sale->event_id = $request->event_id;
                $sale->qty_tickets = $request->qty_tickets;
                $sale->buyer = $request->client_dni . ': ' . $request->client_name . ' (' . $request->client_phone . ')';
                $sale->total = $sale->qty_tickets * $event->price_per_ticket;
                $sale->date = $request->date;


                if ($request->hasFile('voucher')) {
                    $file = $request->file('voucher');
                    $filename = time() . '_' . $file->getClientOriginalName();
                    $path = $file->storeAs('voucher', $filename);
                    $sale->voucher = $path;
                }

                $sale->save();

                $event->remaining_tickets = $event->remaining_tickets - $sale->qty_tickets;
                $event->save();

            } else {
                return redirect()->route('sales.list')->withErrors(['No hay disponibilidad de tickets solicitados']);
            }

       
        } catch (\Exception $e) {
            return redirect()->route('sales.list')->withErrors(['Un error ha ocurrido', $e->getMessage()]);
        }
        
        return redirect()->route('sales.list')->with('success', 'Venta creada correctamente');

    }
    
}
