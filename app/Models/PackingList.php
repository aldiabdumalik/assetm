<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PackingList extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'regional_id',
        'branch_id',
        'pl_code',
        'pl_type',
        'pl_status',
    ];

    public function user() 
    {
        return $this->belongsTo(User::class);    
    }

    public function branch() 
    {
        return $this->belongsTo(Branch::class);    
    }

    public function packingListItem()
    {
        return $this->hasMany(PackingListItem::class, 'packing_list_id');
    }

    public function delivery()
    {
        return $this->belongsToMany(Delivery::class, 'delivery_items');
    }
}
