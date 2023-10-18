<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\TempImage;
use Illuminate\Http\Request;
use Image;

class TempImageController extends Controller
{
    public function create(Request $request){

        $image=$request->image;
        $ext=$image->getClientOriginalExtension();
        $imageName=time().'-'.uniqid().'.'.$ext;

        $image->move('uploads/temp/',$imageName);

        $sourcePath=public_path('uploads/temp/'.$imageName);
        $desPath=public_path('uploads/temp/thumb/'.$imageName);

        //for thumb
        $img = Image::make($sourcePath);
        $img->fit(300, 200);
        $img->save($desPath);


        $tempImage=new TempImage();
        $tempImage->name=$imageName;
        $tempImage->save();

        return response()->json([
            'status'=>'success',
            'imagePath'=> asset('uploads/temp/thumb/'.$imageName),
            'image_id'=>$tempImage->id,
        ]);
    }
}
