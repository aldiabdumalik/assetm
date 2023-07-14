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

    public function packingListItem()
    {
        return $this->hasMany(PackingListItem::class, 'packing_list_id');
    }
}
