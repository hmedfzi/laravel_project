<?php

namespace App\Http\Controllers\admin\ticket;

use Illuminate\Http\Request;
use App\Models\Ticket\Ticket;
use App\Http\Controllers\Controller;

class TicketController extends Controller
{

    public function newTickets()
    {
        $tickets = Ticket::where('seen', 0)->get();
        foreach($tickets as $newTicket){
            $newTicket->update(['seen' => 1]);
            $newTicket->seen = 1 ;
            $result = $newTicket->save();           
        }
        return view('admin.ticket.index', compact('tickets'));
    }

    public function openTickets()
    {
        $tickets = Ticket::where('status', 0)->get();
        return view('admin.ticket.index', compact('tickets'));
    }

    public function closeTickets()
    {
        $tickets = Ticket::where('status', 1)->get();
        return view('admin.ticket.index', compact('tickets'));
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $tickets = Ticket::all();
        return view('admin.ticket.index', compact('tickets'));

    }

    public function change(Ticket $ticket){
        $ticket->status = $ticket->status == 0 ? 1 : 0;
        $result = $ticket->save();
        return redirect()->route('admin.ticket.index')->with('swal-success', 'وضعیت با موفقیت تغییر کرد');
    }

    public function show(Ticket $ticket){
        return view('admin.ticket.show', compact('ticket'));
    }

    public function answer(Request $request, Ticket $ticket){
        $inputs = $request->all();
        $inputs['subject'] = $ticket->subject;
        $inputs['status'] = 0;
        $inputs['seen'] = 1;
        $inputs['reference_id'] = $ticket->admin->id;
        $inputs['user_id'] = 1;
        $inputs['category_id'] = $ticket->category_id;
        $inputs['priority_id'] =$ticket->priority->id;
        $inputs['ticket_id'] =$ticket->id;
        $answer = Ticket::create($inputs);
        return redirect()->route('admin.ticket.index')->with('swal-success','پاسخ شما با موفقیت ثبت شد.');
    }
}
