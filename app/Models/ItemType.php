<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class ItemType extends Model
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'type_name'
    ];

    public function itemBrand()
    {
        return $this->hasMany(ItemBrand::class, 'item_brand_id', 'id');
    }
}
