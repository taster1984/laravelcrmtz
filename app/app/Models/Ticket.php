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
        'body',
        'status',
        'response_date',
    ];

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function files()
    {
        return $this->hasMany(File::class);
    }
}
