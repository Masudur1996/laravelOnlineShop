<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use App\Models\SubCategory;
use Illuminate\Http\Request;

class ShopController extends Controller
{
    public function index(Request $request, $cateorySlug = null, $subCategorySlug = null)
    {
        $categorySelected='';
        $subCategorySelected='';

        $categories = Category::where('status', '1')->where('showHome', 'Yes')->orderBy('name', 'ASC')->get();
        $brands = Brand::where('status', '1')->orderBy('name', 'ASC')->get();


        $products = Product::where('status', '1');

        //filter by catetogy
        if (!empty($cateorySlug)) {
            //here user first() method for get the 1st cateroy
            $category = Category::where('slug', $cateorySlug)->first();
            $products = Product::where('category_id', $category->id);
            $categorySelected=$category->id;
        }

        //filter by subCategory
        if (!empty($subCategorySlug)) {
            //here user first() method for get the 1st cateroy
            $subCategory = SubCategory::where('slug', $subCategorySlug)->first();
            $products = Product::where('sub_category_id', $subCategory->id);
            $subCategorySelected=$subCategory->id;
        }

        $products = $products->orderBy('name', 'ASC')->get();

        return view('front.shop', compact('categories', 'brands', 'products','subCategorySelected','categorySelected'));
    }
}
