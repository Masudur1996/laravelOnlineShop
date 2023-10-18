<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class ShopController extends Controller
{
    public function index(){
        $categories=Category::where('status','1')
        ->where('showHome','Yes')
        ->orderBy('name','ASC')
        ->get();

        $brands=Brand::where('status','1')
        ->orderBy('name','ASC')
        ->get();

        $products=Product::where('status','1')
        ->orderBy('name','ASC')
        ->get();
        return view('front.shop',compact('categories','brands','products'));
    }
}
