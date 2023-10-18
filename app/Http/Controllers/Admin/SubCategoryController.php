<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\SubCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class SubCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->keyword) {
            $search = $request->keyword;
            $subCategories = SubCategory::where('name', 'like', '%' . $search . '%')->paginate();
            return view('admin.sub_category.index', compact('subCategories'));
        } else {
            $subCategories = SubCategory::paginate(10);
            return view('admin.sub_category.index', compact('subCategories'));
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::where('status', 1)->orderBy('name', 'ASC')->get();
        return view('admin.sub_category.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'slug' => 'required|unique:sub_categories',
            'status' => 'required',
            'category_id' => 'required',
        ], [
            'category_id.required' => "Please select an Category",
        ]);


        $subCategory = new SubCategory();
        $subCategory->name = $request->name;
        $subCategory->slug = $request->slug;
        $subCategory->status = $request->status;
        $subCategory->showHome = $request->showHome;
        $subCategory->category_id = $request->category_id;
        $subCategory->save();
        Session::flash('success', 'Sub category added successfully!');
        return response()->json([
            'success' => 'Sub Category Added Successfully',
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function status($id, $status)
    {
        $suscategory = SubCategory::find($id);
        if ($suscategory) {
            $updateStatus = '';
            if ($status == 0) {
                $updateStatus = 1;
            } else {
                $updateStatus = 0;
            }
            $suscategory->status = $updateStatus;
            $suscategory->save();
            Session::flash('success', 'Suatus Updated suceessfully');
            return response()->json([
                'success' => "Suatus Updated suceessfully"
            ]);
        } else {
            Session::flash('error', 'Subcategory not found');
            return redirect()->route('sub-category.index');
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $categories = Category::all();
        $subCategory = SubCategory::find($id);
        if ($subCategory) {
            return view('admin.sub_category.edit', compact('categories', 'subCategory'));
        } else {
            Session::flash('error', 'Sub Category Not Found!');
            return redirect()->route('sub-category.index');
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        $subCategory = SubCategory::find($request->id);
        if ($subCategory) {
            $request->validate([
                'name' => 'required',
                'slug' => 'required|unique:sub_categories,slug,' . $subCategory->id,
                'status' => 'required',
                'category_id' => 'required',
            ], [
                'category_id.required' => "Please select an Category",
            ]);


            $subCategory->name = $request->name;
            $subCategory->slug = $request->slug;
            $subCategory->status = $request->status;
            $subCategory->showHome = $request->showHome;
            $subCategory->category_id = $request->category_id;
            $subCategory->save();
            Session::flash('success', 'Sub category Updated Successfully!');
            return response()->json([
                'success' => 'Sub category Updated Successfully!'
            ]);
        } else {
            Session::flash('error', 'Sub category not found!');
            return response()->json([
                'error' => 'Sub category not found!'
            ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $subCategory = SubCategory::find($id);
        if (!empty($subCategory)) {
            $subCategory->delete();
            Session::flash('success', 'Sub Category Deleted successfully!');
            return response()->json([
                'success' => 'Sub category Deleted Successfully!'
            ]);
        } else {
            Session::flash('error', 'Category Not Found');
            return response()->json([
                'error' => 'Category Not Found',
            ]);
        }
    }
}
