<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\ProductImage;
use App\Models\Category;
use App\Models\SubCategory;
use App\Models\Brand;

class Product extends Model
{
    use HasFactory;

    public function product_images(){
       return $this->hasMany(ProductImage::class);
    }

    public function category(){
        return $this->belongsTo(Category::class);
     }

     public function sub_category(){
        return $this->belongsTo(SubCategory::class);
     }

     public function brand(){
        return $this->belongsTo(Brand::class);
     }


}
