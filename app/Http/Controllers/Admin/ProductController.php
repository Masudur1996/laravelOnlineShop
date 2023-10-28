<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use App\Models\ProductImage;
use App\Models\SubCategory;
use App\Models\TempImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Session;
use Image;


class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $products = Product::latest()->paginate(5);
        return view('admin.product.index', compact('products'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $data['categories'] = Category::where('status','1')->OrderBy('name', 'ASC')->get();
        $data['brands'] = Brand::where('status','1')->OrderBy('name', 'ASC')->get();
        return view('admin.product.create', $data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        $rules = [
            'name' => "required",
            'slug' => "required|unique:products",
            'sku' => "required|unique:products",
            'category' => "required",
            'price' => "required|numeric",
            'is_featured' => "required",
        ];
        if ($request->track_qty && $request->track_qty == 'Yes') {
            $rules["qty"] = 'required|numeric';
        }
        $request->validate($rules);

        $product = new Product();
        $product->name = $request->name;
        $product->slug = $request->slug;
        $product->description = $request->description;
        $product->short_description = $request->short_description;
        $product->related_products = $request->related_products;
        $product->price = $request->price;
        $product->compare_price = $request->compare_price;
        $product->sku = $request->sku;
        $product->barcode = $request->barcode;
        $product->track_qty = $request->track_qty;
        $product->is_featured = $request->is_featured;
        $product->qty = $request->qty;
        $product->status = $request->status;
        $product->category_id = $request->category;
        $product->sub_category_id = $request->sub_category;
        $product->brand_id = $request->brand;
        $product->save();

        if ($request->image) {
            foreach ($request->image as $tempImageId) {
                $tempImage = TempImage::find($tempImageId);

                $product_image = new ProductImage();
                $product_image->name = $tempImage->name;
                $product_image->product_id = $product->id;
                $product_image->save();

                //for large image
                $sourcePath = public_path('uploads/temp/' . $tempImage->name);
                $destPath = public_path('uploads/images/product/large/' . $tempImage->name);
                $img = Image::make($sourcePath);
                $img->resize(1400, null, function ($constraint) {
                    $constraint->aspectRatio();
                });
                $img->save($destPath);

                //for small image
                $destPath = public_path('uploads/images/product/small/' . $tempImage->name);
                $img = Image::make($sourcePath);
                $img->resize(300, 200);
                $img->save($destPath);
            }
            Session::flash('success', 'Product Inserted successfully !');
        }

        return response()->json([
            'success' => 'Product Inserted successfully !',
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function subCategory(Request $request)
    {
        $subCatgories = SubCategory::where('category_id', $request->cat_id)
            ->orderBy('name', 'ASC')
            ->get();
        if ($subCatgories) {
            return response()->json([
                'status' => 'success',
                'subCategories' => $subCatgories
            ]);
        } else {
            return response()->json([
                'status' => 'success',
                'subCategories' => []
            ]);
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $product = Product::find($id);
        $categories = Category::OrderBy('name', 'ASC')->get();
        $brands = Brand::OrderBy('name', 'ASC')->get();
        if ($product) {
            return view('admin.product.edit', compact('categories', 'brands', 'product'));
        } else {
            Session::flash('error', 'Product not found');
            return redirect()->route('product.index');
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        $product = Product::find($request->id);
        if ($product) {
            $rules = [
                'name' => "required",
                'slug' => "required|unique:products,slug," . $product->id,
                'sku' => "required|unique:products,sku," . $product->id,
                'category' => "required",
                'price' => "required|numeric",
                'is_featured' => "required",
            ];
            if ($request->track_qty && $request->track_qty == "Yes") {
                $rules["qty"] = 'required|numeric';
            }
            $request->validate($rules);

            $product->name = $request->name;
            $product->slug = $request->slug;
            $product->description = $request->description;
            $product->short_description = $request->short_description;
            $product->related_products = $request->related_products;
            $product->price = $request->price;
            $product->compare_price = $request->compare_price;
            $product->sku = $request->sku;
            $product->barcode = $request->barcode;
            $product->track_qty = $request->track_qty;
            $product->is_featured = $request->is_featured;
            $product->qty = $request->qty;
            $product->status = $request->status;
            $product->category_id = $request->category;
            $product->sub_category_id = $request->sub_category;
            $product->brand_id = $request->brand;
            $product->save();

            Session::flash('success', 'Product Updated successfully !');
            return response()->json([
                'success' => 'Product Updated successfully',
            ]);
        } else {

            Session::flash('error', 'Product not found');
            return response()->json([
                'error' => 'Product not found',
            ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {

        $product = Product::find($request->id);
        if ($product) {

            foreach ($product->product_images as $key => $image) {
                File::delete(public_path('uploads/images/product/large/' . $image->name));
                File::delete(public_path('uploads/images/product/small/' . $image->name));
                $image->delete();
            }
            $product->delete();
            Session::flash('success', 'Product Deleted successfully');
            return response()->json([
                'success' => 'Product Deleted successfully',
            ]);
        } else {
            Session::flash('error', 'Product not found');
            return response()->json([
                'error' => 'Product not found',
            ]);
        }
    }

    //for image update
    public function imageUpdate(Request $request)
    {

        $image = $request->image;
        $ext = $image->getClientOriginalExtension();
        $sPath = $image->getPathName();
        $imageName = time() . '-' . uniqId() . '.' . $ext;



        //for large image
        $destPath = public_path('/uploads/images/product/large/' . $imageName);
        $img = Image::make($sPath);
        $img->resize(1400, null, function ($constraint) {
            $constraint->aspectRatio();
        });
        $img->save($destPath);

        //for small image
        $destPath = public_path('/uploads/images/product/small/' . $imageName);
        $img = Image::make($sPath);
        $img->resize(300, 200);
        $img->save($destPath);

        $productImage = new ProductImage();
        $productImage->name = $imageName;
        $productImage->product_id = $request->product_id;
        $productImage->save();

        return response()->json([
            'status' => 'success',
            'image_id' => $productImage->id,
            'imagePath' => asset('uploads/images/product/small/' . $imageName),
        ]);
    }

    //for delete image during update
    public function imageDelete(Request $request)
    {


        $image = ProductImage::find($request->id);
        File::delete('uploads/images/product/large/' . $image->name);
        File::delete('uploads/images/product/small/' . $image->name);
        $image->delete();

        return response()->json([
            'status' => 'success'
        ]);
    }
}
