<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class BrandController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->keyword) {
            $search = $request->keyword;
            $brands = Brand::where('name', 'like', '%' . $search . '%')->latest()->paginate();
            return view('admin.brand.index', compact('brands'));
        } else {
            $brands = Brand::latest()->paginate(10);
            return view('admin.brand.index', compact('brands'));
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.brand.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'slug' => 'required|unique:brands',
            'status' => 'required',
        ]);

        $brand = new Brand();
        $brand->name = $request->name;
        $brand->slug = $request->slug;
        $brand->status = $request->status;
        $brand->save();
        Session::flash('success', 'Brand created successfully');
        return response()->json([
            'success' => 'Brand created successfully'
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function status(Request $request)
    {
        $brand = Brand::find($request->id);
        if ($brand) {

            if ($request->status == 0) {
                $brand->status = 1;
            } else {
                $brand->status = 0;
            }
            $brand->save();
            Session::flash('success', 'Brand status updated!');
            return response()->json([
                'success' => 'Brand status updated!'
            ]);
        } else {
            Session::flash('error', 'Brand not Found!');
            return response()->json([
                'error' => 'Brand not Found!'
            ]);
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $brand = Brand::find($id);
        if ($brand) {
            return view('admin.brand.edit', compact('brand'));
        } else {
            Session::flash('error', 'Brand Not Found!');
            return redirect()->route('brand.index');
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request,)
    {
        $brand = Brand::find($request->id);
        if ($brand) {
            $request->validate([
                'name' => 'required',
                'slug' => 'required|unique:brands,slug,' . $brand->id,
                'status' => 'required',
            ]);
            $brand->name = $request->name;
            $brand->slug = $request->slug;
            $brand->status = $request->status;
            $brand->save();
            Session::flash('success', 'Brand updated successfully!');
            return response()->json([
                'success' => 'Brand updated successfully!'
            ]);
        } else {
            Session::flash('error', 'Brand Not Found!');
            return response()->json([
                'error' => 'Brand Not Found!'
            ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $brand = Brand::find($id);
        if ($brand) {
            $brand->delete();
            Session::flash('success', 'Brand Deleted Successfully!');
            return response()->json([
                'success' => 'Brand Deleted Successfully!'
            ]);
        } else {
            Session::flash('error', 'Brand Not Found!');
            return response()->json([
                'error' => 'Brand Not Found!'
            ]);
        }
    }
}
