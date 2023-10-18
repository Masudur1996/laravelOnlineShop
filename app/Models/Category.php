<?php

namespace App\Models;
use App\Models\SubCategory;
use App\Models\Product;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    public function sub_categories(){
       return $this->hasMany(SubCategory::class);
    }
    public function products(){
        return $this->hasMany(Product::class);
     }
 }
