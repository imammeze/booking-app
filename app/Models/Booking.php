<?php

namespace App\Models;

use App\Models\Room;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Booking extends Model
{
    use HasFactory, HasUuids;
    
    protected $keyType = 'string';
    public $incrementing = false;
    
    protected $fillable = ['name', 'phone_number','user_id', 'room_id', 'title', 'start_time', 'end_time', 'status'];

    public function user() 
    { 
        return $this->belongsTo(User::class); 
    }
    public function room() 
    { 
        return $this->belongsTo(Room::class); 
    }
}