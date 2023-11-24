<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'status'
    ];

    public function items(){
        return $this->hasMany(Item::class, 'order_item');
    }
}
