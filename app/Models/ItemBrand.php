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

    public function itemType()
    {
        return $this->belongsTo(ItemType::class, 'item_type_id');
    }

    public function itemModel()
    {
        return $this->hasMany(ItemModel::class, 'item_brand_id');
    }
}
