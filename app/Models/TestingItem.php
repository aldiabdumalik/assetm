<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class TestingItem extends Model
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'user_id',
        'model_id',
        'barcode',
        'status',
        'box_ok',
        'box_nok',
        'type_desc',
        'brand_desc',
        'model_desc',
        'status_scan'
    ];
}
