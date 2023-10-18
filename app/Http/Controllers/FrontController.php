<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class FrontController extends Controller
{
   public function index(){
    $featuredProducts=Product::where('is_featured','Yes')
    ->where('status','1')
    ->latest()
    ->take(8)
    ->get();

    $latestProducts=Product::where('status','1')
    ->latest()
    ->take(8)
    ->get();
    return view('front.home',compact('featuredProducts','latestProducts'));
   }
}
