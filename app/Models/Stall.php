<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Stall extends Model
{
    protected $fillable = [
        'user_id',
        'name',
        'description',
        'photo',
        'is_active',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function foodItems()
    {
        return $this->hasMany(FoodItem::class);
    }
}
