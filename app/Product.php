<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        'category_id ','en_product_title','ar_product_title','en_product_description','ar_product_description','en_product_price','ar_product_price','product_image_url','product_status'
    ];

    protected $table = 'product';
}
