<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $fillable = [
        'menu_id ','en_category_title ','ar_category_title ','category_image_url ','category_status'
    ];

    protected $table = 'category';
}
