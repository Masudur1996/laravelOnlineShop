<?php

use App\Models\Category;

function categories(){
  return Category::orderBy('name','ASC')
   ->where('status','1')
   ->with('sub_categories')
   ->where('showHome','Yes')
   ->get();
}
