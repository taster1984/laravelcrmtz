<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\WidgetRequest;
use App\Http\Resources\TicketResource;
use App\Models\File;
use App\Models\Ticket;
use App\Models\Customer;

class TicketController extends Controller
{
    public function store(WidgetRequest $request)
    {
        $customer = Customer::firstOrCreate(
            [
                'email' => $request->email,
                'phone' => $request->phone,
            ],
            [
                'name' => $request->name,
            ]
        );
        $recentTicket = Ticket::where('customer_id', $customer->id)
            ->where('created_at', '>=', now()->subDay())
            ->first();

        if ($recentTicket) {
            return response()->json([
                'message' => 'Вы можете создать только 1 тикет в сутки.'
            ], 422);
        }

         $ticket = Ticket::create([
            'customer_id' => $customer->id,
            'subject' => $request->subject,
            'body' => $request->body,
            'status' => 'new'
        ]);


        if ($request->hasFile('files')) {
            foreach ($request->file('files') as $uploadedFile) {
                $fileModel = File::factory()->create([
                    'ticket_id' => $ticket->id,
                    'title'     => $uploadedFile->getClientOriginalName(),
                    'type'      => $uploadedFile->getClientMimeType(),
                ]);

                $fileModel->addMedia($uploadedFile)->toMediaCollection('files');
            }
        }
        return new TicketResource($ticket);
    }
}
