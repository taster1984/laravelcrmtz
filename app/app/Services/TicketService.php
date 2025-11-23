<?php

namespace App\Services;

use App\Models\Ticket;
use Illuminate\Support\Carbon;

class TicketService
{
    /**
     * Получить список тикетов с фильтрацией
     *
     * @param array $filters
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function getTickets(array $filters = [])
    {
        $query = Ticket::query()->with('customer', 'files');

        if (!empty($filters['status'])) {
            $query->where('status', $filters['status']);
        }

        if (!empty($filters['email'])) {
            $query->whereHas('customer', function($q) use ($filters) {
                $q->where('email', 'like', "%{$filters['email']}%");
            });
        }

        if (!empty($filters['phone'])) {
            $query->whereHas('customer', function($q) use ($filters) {
                $q->where('phone', 'like', "%{$filters['phone']}%");
            });
        }

        if (!empty($filters['from'])) {
            $query->whereDate('created_at', '>=', Carbon::parse($filters['from']));
        }

        if (!empty($filters['to'])) {
            $query->whereDate('created_at', '<=', Carbon::parse($filters['to']));
        }

        return $query->orderBy('created_at', 'desc')->paginate(20);
    }

    /**
     * Получить один тикет
     */
    public function getTicket(int $ticketId)
    {
        return Ticket::with('customer', 'files')->findOrFail($ticketId);
    }

    /**
     * Сменить статус тикета
     */
    public function changeStatus(int $ticketId, string $status)
    {
        $ticket = Ticket::findOrFail($ticketId);
        $ticket->status = $status;

        $ticket->save();

        return $ticket;
    }

    /**
     * Статистика тикетов по статусам за день, неделю, месяц
     */
    public function getStatistics()
    {
        $now = Carbon::now();

        $periods = [
            'day' => $now->copy()->subDay(),
            'week' => $now->copy()->subWeek(),
            'month' => $now->copy()->subMonth(),
        ];

        $stats = [];

        foreach ($periods as $key => $from) {
            $stats[$key] = Ticket::select('status')
                ->where('created_at', '>=', $from)
                ->groupBy('status')
                ->selectRaw('status, count(*) as count')
                ->pluck('count', 'status')
                ->toArray();
        }

        return $stats;
    }
}
