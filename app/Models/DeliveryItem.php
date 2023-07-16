<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DeliveryItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'packing_list_id',
        'delivery_id',
        'user_id',
        'status',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);    
    }

    
}
