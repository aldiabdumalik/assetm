<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class ItemBrand extends Model
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'item_type_id',
        'brand_name',
    ];
}
