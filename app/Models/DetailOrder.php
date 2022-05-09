<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetailOrder extends Model
{
    use HasFactory;
    protected $fillable = 
    [
        'order_id',
        'product',
        'price'
    ];
    protected $table       = 'detail_orders';
    protected $primaryKey  = 'id';
}
