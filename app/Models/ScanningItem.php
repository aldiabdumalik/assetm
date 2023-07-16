<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class ScanningItem extends Model
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'user_id',
        'arrival_item_id',
        'model_id',
        'scan_box',
        'scan_sn',
        'scan_mac',
        'status',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function arrivalItem()
    {
        return $this->belongsTo(ArrivalItem::class);
    }

    public function itemModel()
    {
        return $this->belongsTo(itemModel::class, 'model_id', 'id');
    }

    public function ujiFungsi()
    {
        return $this->belongsTo(TestingItem::class, 'scan_sn', 'barcode');    
    }

    public function packingListItem()
    {
        return $this->belongsTo(PackingListItem::class, 'scan_sn', 'barcode');    
    }
}
