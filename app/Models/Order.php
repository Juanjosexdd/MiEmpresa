<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;
    protected $fillable = [
        'client',
        'address',
        'phone',
        'way_pay',
        'total',
        'date',
        'ticket',
        'status'
    ];
    protected $table      = 'orders';
    protected $primaryKey = 'id';
}
