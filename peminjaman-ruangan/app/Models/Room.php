<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
    protected $fillable = ['nama', 'lantai', 'deskripsi', 'status'];

    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }
    public function room()
{
    return $this->belongsTo(Room::class, 'room_id');
}
}
