<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Regional extends Model
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'regional_name'
    ];

    public function scopeSearch($query, $field, $value){
        return $query->where($field, 'LIKE', "%$value%");
    }
}