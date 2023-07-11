<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class ArrivalItem extends Model
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'user_id',
        'branch_id',
        'regional_desc',
        'branch_desc',
        'delivery_pic',
        'no_po',
        'user_pic',
        'arrival_date',
        'arrival_total',
        'arrival_note',
    ];

    public function branch()
    {
        return $this->belongsTo(Branch::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function scanningItem()
    {
        return $this->hasMany(ScanningItem::class, 'arrival_item_id', 'id');
    }

}
