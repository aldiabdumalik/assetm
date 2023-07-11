<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class ItemModel extends Model
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'item_brand_id',
        'model_name',
    ];
}
