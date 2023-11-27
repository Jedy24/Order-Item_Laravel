<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    use HasFactory;

    protected $primaryKey = 'id';
    public $increment = false;

    protected $fillable = [
        'id',
        'nama',
        'harga',
        'stok'
    ];

    public function orders(){
        return $this->belongsToMany(Order::class, 'order_item');
    }
}
