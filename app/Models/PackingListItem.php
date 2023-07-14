<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PackingListItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'packing_list_id',
        'user_id',
        'regional_id',
        'model_id',
        'barcode',
        'mac',
        'status_scan',
        'delivery_status',
    ];

    public function packingList()
    {
        return $this->belongsTo(PackingList::class);
    }

    public function user() 
    {
        return $this->belongsTo(User::class);    
    }

    public function itemModel() 
    {
        return $this->belongsTo(itemModel::class, 'model_id');    
    }
}
