<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\admin\BrandController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\SubCategoryController;
use App\Http\Controllers\admin\TempImageController;
use App\Http\Controllers\FrontController;
use App\Http\Controllers\ShopController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Str;






Route::get('/', [FrontController::class, 'index'])->name('front.home');
Route::get('/shop/{cateorySlug?}/{subCategorySlug?}', [ShopController::class, 'index'])->name('shop.home');
Route::get('product/{slug}',[ShopController::class,'product'])->name('front.product');



Route::group(['prefix' => 'admin'], function () {

    Route::group(['middleware' => 'admin.guest'], function () {
        Route::get('/login', [AdminController::class, 'index'])->name('admin.login');
        Route::post('/login/auth', [AdminController::class, 'auth'])->name('admin.auth');
    });
    Route::group(['middleware' => 'admin.auth'], function () {
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');
        Route::get('/logout', [DashboardController::class, 'logout'])->name('admin.logout');

        //route for category
        Route::get('/category', [CategoryController::class, 'index'])->name('category.index');
        Route::get('/category/create', [CategoryController::class, 'create'])->name('category.create');
        Route::post('/category/store', [CategoryController::class, 'store'])->name('category.store');
        Route::get('/category/{id}/edit', [CategoryController::class, 'edit'])->name('category.edit');
        Route::post('/category/update', [CategoryController::class, 'update'])->name('category.update');
        Route::delete('/category/{id}/delete', [CategoryController::class, 'destroy'])->name('category.destroy');
        //for category status update
        Route::get('/category/{id}/{status}', [CategoryController::class, 'status'])->name('category.status');


        //route for sub-category
        Route::get('/sub-category', [SubCategoryController::class, 'index'])->name('sub-category.index');
        Route::get('/sub-category/create', [SubCategoryController::class, 'create'])->name('sub-category.create');
        Route::post('/sub-category/store', [SubCategoryController::class, 'store'])->name('sub-category.store');
        Route::get('/sub-category/{id}/edit', [SubCategoryController::class, 'edit'])->name('sub-category.edit');
        Route::post('/sub-category/update', [SubCategoryController::class, 'update'])->name('sub-category.update');
        Route::delete('/sub-category/{id}/delete', [SubCategoryController::class, 'destroy'])->name('sub-category.destroy');
        //for sub-category status update
        Route::get('/sub-category/{id}/{status}', [SubCategoryController::class, 'status'])->name('sub-category.status');


        //route for barnd
        Route::get('/brand', [BrandController::class, 'index'])->name('brand.index');
        Route::get('/brand/create', [BrandController::class, 'create'])->name('brand.create');
        Route::post('/brand/store', [BrandController::class, 'store'])->name('brand.store');
        Route::get('/brand/{id}/edit', [BrandController::class, 'edit'])->name('brand.edit');
        Route::post('/brand/update', [BrandController::class, 'update'])->name('brand.update');
        Route::delete('/brand/{id}/destroy', [BrandController::class, 'destroy'])->name('brand.destroy');
        //for brand status update
        Route::post('/brand/status', [BrandController::class, 'status'])->name('brand.status');

        //Route for product
        Route::get('/product', [ProductController::class, 'index'])->name('product.index');
        Route::get('/product/create', [ProductController::class, 'create'])->name('product.create');
        Route::post('/product/store', [ProductController::class, 'store'])->name('product.store');
        Route::get('/product/{id}/edit', [ProductController::class, 'edit'])->name('product.edit');
        Route::post('/product/update', [ProductController::class, 'update'])->name('product.update');
        Route::post('/product/destroy', [ProductController::class, 'destroy'])->name('product.destroy');

        //for related product filed
        Route::get('/product/get-product',[ProductController::class,'getProducts'])->name('product.getProducts');


        //for add image during update
        Route::post('/product-image/update', [ProductController::class, 'imageUpdate'])->name('product-image.update');
        //for delete image during update
        Route::post('/product-image/delete', [ProductController::class, 'imageDelete'])->name('product-image.delete');
        //for procut sub category show in form
        Route::get('/product/sub-category', [ProductController::class, 'subCategory'])->name('product.sub-category');


        //for temp image
        Route::post('/temp-image', [TempImageController::class, 'create'])->name('temp-images.create');
        //for prepare  slug
        Route::get('/change/slug', function (Request $request) {
            $slug = Str::slug($request->name);
            return $slug;
        })->name('change.slug');
    });
});
