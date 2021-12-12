<?php

namespace Modules\OpenfoodfactsSearchProducts\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'product_name',
        'categories',
        'categories_tags',
        'image_url',
    ];
}
