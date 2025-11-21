<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    /** @use HasFactory<\Database\Factories\TicketFactory> */
    use HasFactory;
    protected $fillable = [
        'customer_id',
        'subject',
        'text',
        'status',
        'response_date',
    ];

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }
}
