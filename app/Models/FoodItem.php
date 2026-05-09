<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FoodItem extends Model
{
    protected $fillable = [
        'stall_id',
        'name',
        'description',
        'price',
        'photo',
        'is_available',
    ];

    public function stall()
    {
        return $this->belongsTo(Stall::class);
    }
}
