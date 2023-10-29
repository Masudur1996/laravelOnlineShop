@extends('admin.layout.master')

@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid my-2">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Create Product</h1>
                </div>
                <div class="col-sm-6 text-right">
                    <a href="{{ route('product.index') }}" class="btn btn-primary">Back</a>
                </div>
            </div>
        </div>
        <!-- /.container-fluid -->
    </section>
    <!-- Main content -->
    <section class="content">
        <!-- Default box -->
        <form action="" id="productForm" class="productForm">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-8">
                        <div class="card mb-3">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="mb-3">
                                            <label for="name">Name</label>
                                            <input type="text" name="name" id="name" class="form-control"
                                                placeholder="Name">
                                            <span class="text-danger" id='nameError'></span>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="mb-3">
                                            <label for="slug">Slug</label>
                                            <input type="text" readonly name="slug" id="slug"
                                                class="form-control" placeholder="Slug">
                                            <span class="text-danger" id='slugError'></span>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="mb-3">
                                            <label for="description">Description</label>
                                            <textarea name="description" id="description" cols="30" rows="10" class="summernote"
                                                placeholder="Description"></textarea>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="mb-3">
                                            <label for="short_description">Short Description</label>
                                            <textarea name="short_description" id="short_description" class="summernote"></textarea>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                        <div class="card mb-3">
                            <div class="card-body">
                                <h2 class="h4 mb-3">Image</h2>
                                <div id="image" class="dropzone dz-clickable">
                                    <div class="dz-message needsclick">
                                        <br>Drop files here or click to upload.<br><br>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card">
                            <div class="row" id="showImage">

                            </div>
                        </div>

                        <div class="card mb-3">
                            <div class="card-body">
                                <h2 class="h4 mb-3">Pricing</h2>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="mb-3">
                                            <label for="price">Price</label>
                                            <input type="text" name="price" id="price" class="form-control"
                                                placeholder="Price">
                                            <span class="text-danger" id='priceError'></span>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="mb-3">
                                            <label for="compare_price">Compare at Price</label>
                                            <input type="text" name="compare_price" id="compare_price"
                                                class="form-control" placeholder="Compare Price">
                                            <p class="text-muted mt-3">
                                                To show a reduced price, move the product’s original price into Compare at
                                                price. Enter a lower value into Price.
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card mb-3">
                            <div class="card-body">
                                <h2 class="h4 mb-3">Inventory</h2>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="sku">SKU (Stock Keeping Unit)</label>
                                            <input type="text" name="sku" id="sku" class="form-control"
                                                placeholder="sku">
                                            <span class="text-danger" id='skuError'></span>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="barcode">Barcode</label>
                                            <input type="text" name="barcode" id="barcode" class="form-control"
                                                placeholder="Barcode">
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="mb-3">
                                            <div class="custom-control custom-checkbox">
                                                <input type="hidden" name="track_qty" value="No">
                                                <input class="custom-control-input" type="checkbox" id="track_qty"
                                                    name="track_qty" value="Yes" checked>
                                                <label for="track_qty" class="custom-control-label">Track Quantity</label>
                                            </div>
                                        </div>
                                        <div class="mb-3">
                                            <input type="number" min="0" name="qty" id="qty"
                                                class="form-control" placeholder="Qty">
                                            <span class="text-danger" id='qtyError'></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="card mb-3">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-12">
                                        <h2 class="h4 mb-3">Related Products</h2>
                                        <div class="mb-3">
                                            <select multiple class="related_products w-100" name="related_products[]" id="related_products">

                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card mb-3">
                            <div class="card-body">
                                <h2 class="h4 mb-3">Product status</h2>
                                <div class="mb-3">
                                    <select name="status" id="status" class="form-control">
                                        <option value="1">Active</option>
                                        <option value="0">Block</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="card">
                            <div class="card-body">
                                <h2 class="h4  mb-3">Product category</h2>
                                <div class="mb-3">
                                    <label for="category">Category</label>
                                    <select name="category" id="category" class="form-control">
                                        <option value="">Select a category</option>
                                        @foreach ($categories as $category)
                                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                                        @endforeach
                                    </select>
                                    <span class="text-danger" id='categoryError'></span>
                                </div>
                                <div class="mb-3">
                                    <label for="category">Sub category</label>
                                    <select name="sub_category" id="sub_category" class="form-control">
                                        <option value="">Select a sub category</option>

                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="card mb-3">
                            <div class="card-body">
                                <h2 class="h4 mb-3">Product brand</h2>
                                <div class="mb-3">
                                    <select name="brand" id="brand" class="form-control">
                                        <option value="">Select a brand</option>
                                        @foreach ($brands as $brand)
                                            <option value="{{ $brand->id }}">{{ $brand->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="card mb-3">
                            <div class="card-body">
                                <h2 class="h4 mb-3">Featured product</h2>
                                <div class="mb-3">
                                    <select name="is_featured" id="is_featured" class="form-control">
                                        <option value="Yes">Yes</option>
                                        <option value="No">No</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="pb-5 pt-3">
                    <button type='submit' class="btn btn-primary">Create</button>
                    <a href="{{ route('product.index') }}" class="btn btn-outline-dark ml-3">Cancel</a>
                </div>
            </div>
        </form>
        <!-- /.card -->
    </section>
    <!-- /.content -->
@endsection


@section('custom_js')
    <script>
        $(document).ready(function() {

            //for summernote
            $('.summernote').summernote({
                height: '200px'
            });

            //for slug
            $('#name').keyup(function() {
                let name = $(this).val();
                $.ajax({
                    url: '{{ route('change.slug') }}',
                    method: 'get',
                    data: {
                        name: name
                    },
                    success: function(res) {
                        $('#slug').val(res)
                    }
                })
            })

            //for load sub category
            $('#category').change(function() {
                let cat_id = $(this).val();
                $.ajax({
                    url: '{{ route('product.sub-category') }}',
                    method: 'get',
                    data: {
                        cat_id: cat_id
                    },
                    success: function(res) {
                        $('#sub_category').find('option').not(':first').remove();
                        $.each(res.subCategories, function(key, subCategory) {
                            $("#sub_category").append(
                                `<option value="${subCategory.id}">${subCategory.name}</option>`
                            );
                        })

                    }
                })
            })

            //for add procut
            $('#productForm').submit(function(e) {
                e.preventDefault();
                let formData = new FormData(this);

                $('#nameError').html('')
                $('#name').removeClass('is-invalid')

                $('#slugError').html('')
                $('#slug').removeClass('is-invalid')

                $('#skuError').html('')
                $('#sku').removeClass('is-invalid')

                $('#categoryError').html('')
                $('#category').removeClass('is-invalid')

                $('#price').removeClass('is-invalid')
                $('#priceError').html('')

                $('#qty').removeClass('is-invalid')
                $('#qtyError').html('')

                $('#is_featured').removeClass('is-invalid')
                $('#is_featuredError').html('')

                $.ajax({
                    url: '{{ route('product.store') }}',
                    method: 'post',
                    data: formData,
                    processData: false,
                    contentType: false,

                    success: function(res) {
                        window.location.href = '{{ route('product.index') }}';
                    },
                    error: function(err) {
                        if (err.responseJSON.errors.name) {
                            $('#name').addClass('is-invalid')
                            $('#nameError').html(err.responseJSON.errors.name)
                        }
                        if (err.responseJSON.errors.slug) {
                            $('#slug').addClass('is-invalid')
                            $('#slugError').html(err.responseJSON.errors.slug)
                        }
                        if (err.responseJSON.errors.sku) {
                            $('#sku').addClass('is-invalid')
                            $('#skuError').html(err.responseJSON.errors.sku)
                        }
                        if (err.responseJSON.errors.category) {
                            $('#category').addClass('is-invalid')
                            $('#categoryError').html(err.responseJSON.errors.category)
                        }

                        if (err.responseJSON.errors.is_featured) {
                            $('#is_featured').addClass('is-invalid')
                            $('#is_featuredError').html(err.responseJSON.errors.is_featured)
                        }
                        if (err.responseJSON.errors.price) {
                            $('#price').addClass('is-invalid')
                            $('#priceError').html(err.responseJSON.errors.price)
                        }

                        if (err.responseJSON.errors.qty) {
                            $('#qty').addClass('is-invalid')
                            $('#qtyError').html(err.responseJSON.errors.qty)
                        }

                    }
                })
            })
        })
        //for select2 option in related_product
        $('.related_products').select2({
            ajax: {
                url: '{{ route("product.getProducts") }}',
                dataType: 'json',
                tags: true,
                multiple: true,
                minimumInputLength: 3,
                processResults: function(data) {
                    return {
                        results: data.tags
                    };
                }
            }
        });
        //start of dropzone
        Dropzone.autoDiscover = false;
        const dropzone = $("#image").dropzone({
            init: function() {
                this.on('addedfile', function(file) {
                    if (this.files.length > 5) {
                        this.removeFile(this.files[0]);
                    }
                });
            },

            url: "{{ route('temp-images.create') }}",
            maxFiles: 5,
            paramName: 'image',
            addRemoveLinks: true,
            acceptedFiles: "image/jpeg,image/png,image/gif",
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(file, response) {
                //$("#image_id").val(response.image_id);

                var html = `<div class="col-sm-3 mt-3" id='deleteImage${response.image_id}'><div class="card">
                            <input type="hidden" name="image[]" value="${response.image_id}"> </input>
                            <img class="card-img-top" src="${response.imagePath}" alt="Card image cap">
                            <div class="card-body">
                                <a onclick="deleteDropzoneImage(${response.image_id})" class="btn btn-sm btn-danger">Delete</a>
                            </div>
                            </div></div>`;
                $('#showImage').append(html);
            },
            complete: function(file) {
                this.removeFile(file);
            }
        });
        //end of dropzone
        function deleteDropzoneImage(id) {
            $('#deleteImage' + id).remove();
        }
    </script>
@endsection
