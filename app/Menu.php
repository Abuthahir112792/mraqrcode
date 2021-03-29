<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    protected $fillable = [
        'en_menu_title ','ar_menu_title','menu_status'
    ];

    protected $table = 'menu';
}
