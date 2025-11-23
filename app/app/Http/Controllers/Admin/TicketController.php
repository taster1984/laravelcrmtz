<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\TicketService;
use Illuminate\Http\Request;

class TicketController extends Controller
{
    protected TicketService $service;

    public function __construct(TicketService $service)
    {
        $this->service = $service;
        $this->middleware('auth'); // доступ только менеджеру
    }

    /**
     * Список тикетов с фильтрацией
     */
    public function index(Request $request)
    {
        $filters = $request->only(['status', 'email', 'phone', 'from', 'to']);
        $tickets = $this->service->getTickets($filters);

        return view('admin.tickets.index', compact('tickets', 'filters'));
    }

    /**
     * Просмотр деталей тикета
     */
    public function show(int $ticketId)
    {
        $ticket = $this->service->getTicket($ticketId);
        return view('admin.tickets.show', compact('ticket'));
    }



    /**
     * Смена статуса тикета
     */
    public function updateStatus(Request $request, int $ticketId)
    {
        $request->validate([
            'status' => 'required|string|in:new,in_progress,processed',
        ]);

        $ticket = $this->service->changeStatus($ticketId, $request->status);

        if (in_array($request->status, ['processed'])) {
            $ticket->response_date = now();
            $ticket->save();
        }

        return redirect()->back()->with('success', 'Статус тикета обновлен');}
}
