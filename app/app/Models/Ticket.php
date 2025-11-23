<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Carbon\Carbon;
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

    public function scopeLastDay(Builder $query)
    {
        return $query->where('created_at', '>=', Carbon::now()->subDay());
    }

    public function scopeLastWeek(Builder $query)
    {
        return $query->where('created_at', '>=', Carbon::now()->subWeek());
    }

    public function scopeLastMonth(Builder $query)
    {
        return $query->where('created_at', '>=', Carbon::now()->subMonth());
    }
}
