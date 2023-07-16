<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Delivery extends Model
{
    use HasFactory;

    protected $fillable = [
        'packing_list_id',
        'delivery_branch_id',
        'user_id',
        'delivery_no',
        'delivery_resi',
        'jml_item',
        'estimasi',
        'status',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function branchDelivery()
    {
        return $this->belongsTo(Branch::class, 'delivery_branch_id', 'id');
    }

    public function deliveryItem()
    {
        return $this->hasMany(DeliveryItem::class, 'delivery_id', 'id');    
    }

    public function packingList()
    {
        return $this->belongsToMany(PackingList::class, 'delivery_items');    
    }
}
