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
        $categorySelected = '';
        $subCategorySelected = '';
        $brandArray = [];
        $price_min = 0;
        $price_max = 0;
        $sort = '';





        $categories = Category::where('status', '1')->where('showHome', 'Yes')->orderBy('name', 'ASC')->get();
        $brands = Brand::where('status', '1')->orderBy('name', 'ASC')->get();


        $products = Product::where('status', '1');

        //filter by catetogy
        if (!empty($cateorySlug)) {
            //here user first() method for get the 1st cateroy
            $category = Category::where('slug', $cateorySlug)->first();
            $products = $products->where('category_id', $category->id);
            $categorySelected = $category->id;
        }

        //filter by subCategory
        if (!empty($subCategorySlug)) {
            //here user first() method for get the 1st cateroy
            $subCategory = SubCategory::where('slug', $subCategorySlug)->first();
            $products = $products->where('sub_category_id', $subCategory->id);
            $subCategorySelected = $subCategory->id;
        }

        //filter by brands
        if (!empty($request->get('brand'))) {
            //explode method will break string by the basis of , and store into brandArray
            $brandArray = explode(',', $request->get('brand'));
            $products = $products->whereIn('brand_id', $brandArray);
        }
        if ($request->get('price_min') != '' && $request->get('price_max') != '') {
            $price_min = intval($request->get('price_min'));
            $price_max = intval($request->get('price_max'));

            if ($price_max == 40000) {
                $products = $products->whereBetween('price', [$price_min, 40000000]);
            } else {
                $products = $products->whereBetween('price', [$price_min, $price_max]);
            }
        }

        if ($price_max == 0) {
            $price_max = 40000;
        }


        if ($request->get('sort') != '') {
            if ($request->get('sort') == 'price_desc') {
                $products = $products->orderBy('price', 'DESC');
            } elseif ($request->get('sort') == 'price_asc') {
                $products = $products->orderBy('price', 'ASC');
            } else {
                $products = $products->orderBy('id', 'DESC');
            }

            $sort = $request->get('sort');
        } else {
            $products = $products->orderBy('id', 'DESC');
        }




        $products = $products->paginate(9);

        return view('front.shop', compact('categories', 'brands', 'products', 'subCategorySelected', 'categorySelected', 'brandArray', 'price_min', 'price_max', 'sort'));
    }

    public function product($slug)
    {

        $product = Product::where('slug', $slug)->first();

        if ($product==null) {
            abort(404);
        } else {
            $relatedProducts = [];

            if ($product->related_products != '') {
                $productArray = explode(',', $product->related_products);

                $relatedProducts = Product::whereIn('id', $productArray)->get();
            }
            return view('front.product', compact('product', 'relatedProducts'));
        }
    }
}
