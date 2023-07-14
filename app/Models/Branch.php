<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Branch extends Model
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'regional_id',
        'branch_name',
        'branch_type'
    ];

    public function regional()
    {
        return $this->belongsTo(Regional::class);
    }
}
