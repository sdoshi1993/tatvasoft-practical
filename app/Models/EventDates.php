<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EventDates extends Model
{
    use HasFactory;
    protected $table = 'event_dates'; 
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'intFkEventId',
        'dtDates'
    ];

    protected $timestamp = false; 

}
