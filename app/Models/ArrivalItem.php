<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class ArrivalItem extends Model
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'user_id',
        'branch_id',
        'regional_desc',
        'branch_desc',
        'delivery_pic',
        'user_pic',
        'arrival_date',
        'arrival_total',
        'arrival_note',
    ];
}
