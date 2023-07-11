<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class ScanningItem extends Model
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'user_id',
        'arrival_item_id',
        'model_id',
        'scan_box',
        'scan_sn',
        'scan_mac',
    ];
}
