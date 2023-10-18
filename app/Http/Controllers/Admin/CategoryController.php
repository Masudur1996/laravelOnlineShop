<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\File;
use Image;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {

        if ($request->keyword) {
            $search = $request->keyword;
            $data['categories'] = Category::where('name', 'like', '%' . $search . '%')->paginate();
            return view('admin.category.index', $data);
        } else {
            $data['categories'] = Category::latest()->paginate(10);
            return view('admin.category.index', $data);
        }
    }
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.category.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|max:20',
            'slug' => 'required|unique:categories',
            'image' => 'required|mimes:png,jpg',
            'status' => 'required',
            'showHome' => 'required',
        ]);

        if (!empty($request->image)) {
            $image = $request->image;
            $ext = $image->getClientOriginalExtension();
            $imageName = time() . '-' . uniqId() . '.' . $ext;
            $image->move('uploads/images/category/', $imageName);



            //for thumb image
            $img = Image::make('uploads/images/category/' . $imageName);
            $img->resize(300, 300);
            $img->save('uploads/images/category/thumbs/' . $imageName);
        }
        $model = new Category();
        $model->name = $request->name;
        $model->status = $request->status;
        $model->slug = $request->slug;
        $model->showHome = $request->showHome;
        $model->image = $imageName;
        $model->save();
        Session::flash('success', 'Category Created Successfully');
        return response()->json([
            'success' => "Category Inserted Successfully"
        ]);
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $category = Category::find($id);
        if (!empty($category)) {
            return view('admin.category.edit', compact('category'));
        } else {
            Session::flash('error', 'Category not found');
            return redirect()->route('category.index');
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request,)
    {
        $category = Category::find($request->id);
        if ($category) {
            $request->validate([
                'name' => 'required',
                'slug' => 'required|unique:categories,slug,' . $category->id,
                'image' => 'mimes:png,jpg',
            ]);
            $category = Category::find($request->id);
            $imageName = '';
            if ($request->image) {

                $image = $request->image;
                $ext = $image->getClientOriginalExtension();
                $imageName = time() . '-' . uniqId() . '.' . $ext;

                //remove old image and thumb
                $oldImage = 'uploads/images/category/' . $category->image;
                $oldImageThumb = 'uploads/images/category/thumbs/' . $category->image;
                file::delete($oldImage);
                file::delete($oldImageThumb);

                //save new image
                $image->move('uploads/images/category/', $imageName);

                //for thumb
                $img = Image::make('uploads/images/category/' . $imageName);
                $img->resize(300, 300);
                $img->save('uploads/images/category/thumbs/' . $imageName);
            } else {
                $imageName = $category->image;
            }

            $category->name = $request->name;
            $category->slug = $request->slug;
            $category->image = $imageName;
            $category->status = $request->status;
            $category->showHome = $request->showHome;
            $category->save();

        }else{
            Session::flash('error', 'Category not found');

            return response()->json([
                'error' => 'Category not found',
            ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $category = Category::find($id);

        if (!empty($category)) {
            //for remove image and thumbs
            file::delete('uploads/images/category/' . $category->image);
            file::delete('uploads/images/category/thumbs/' . $category->image);

            $category->delete();
            Session::flash('success', 'Category Deleted Successfully');
            return response()->json([
                'success' => 'Category Deleted Successfully',
            ]);
        } else {
            Session::flash('error', 'Category Not Found');
            return response()->json([
                'error' => 'Category Not Found',
            ]);
        }
    }

    public function status($id, $status)
    {

        $category = Category::find($id);
        if (!empty($category)) {
            if ($status == 0) {
                $category->status = 1;
                $category->save();
            } else {
                $category->status = 0;
                $category->save();
            }
            Session::flash('success', 'Category status updated');
            return response()->json([
                'success' => 'Category status updated',
            ]);
        } else {
            Session::flash('error', 'Category not found');
            return redirect()->route('category.index');
        }
    }
}
