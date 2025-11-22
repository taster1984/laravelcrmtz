<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class File extends Model implements HasMedia

{
    use InteractsWithMedia;
    /** @use HasFactory<\Database\Factories\FileFactory> */
    use HasFactory;

    protected $fillable = [
        'ticket_id',
        'title',
        'type',
    ];

    public function ticket()
    {
        return $this->belongsTo(Ticket::class);
    }

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('files')->useDisk('public');
    }
}
