<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TicketResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'customer' => [
                'id' => $this->customer->id,
                'name' => $this->customer->name,
                'email' => $this->customer->email,
                'phone' => $this->customer->phone,
            ],
            'subject' => $this->subject,
            'body' => $this->body,
            'status' => $this->status,
            'files' => $this->files->map(fn($f) => $f->getFirstMedia('files')),
            'created_at' => $this->created_at,
        ];
    }
}
