<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    use HasFactory;
    protected $fillable =
    [
        'logo_home',
        'logo_shop',
        'logo_footer',
        'phone',
        'url_fb',
        'url_insta',
        'url_maps',
        'yape',
        'plin',
        'transferencia',
        'address',
        'name_company'
    ];

    protected $table      = 'settings';
    protected $primaryKey = 'id';

}
