<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Ticket;
use Illuminate\Support\Facades\DB;


class TicketStatisticsController extends Controller
{
    public function index()
    {
        $periods = [
            'day' => Ticket::lastDay(),
            'week' => Ticket::lastWeek(),
            'month' => Ticket::lastMonth(),
        ];

        $stats = [];

        foreach ($periods as $key => $query) {
            $stats[$key] = $query
                ->select('status', DB::raw('count(*) as total'))
                ->groupBy('status')
                ->pluck('total', 'status');
        }

        return response()->json($stats);
    }
}
