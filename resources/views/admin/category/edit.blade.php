@extends('admin.layout.master')

@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid my-2">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Edit Category : {{ $category->name }}</h1>
                </div>
                <div class="col-sm-6 text-right">
                    <a href="{{ route('category.index') }}" class="btn btn-primary">Back</a>
                </div>
            </div>
        </div>
        <!-- /.container-fluid -->
    </section>
    <!-- Main content -->

    <section class="content">
        <form id="editCategoryForm">
            <!-- Default box -->
            <div class="container-fluid">
                <div class="card">
                    <div class="card-body">

                        <div class="row">
                            <!-- for id -->
                            <input type="hidden" name="id" id="id" value="{{ $category->id }}">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="name">Name</label>
                                    <input type="text" name="name" id="name" value="{{ $category->name }}"
                                        class="form-control" placeholder="Name">
                                    <span class="text-danger" id='nameError'></span>
                                </div>

                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="slug">Slug</label>
                                    <input type="text" name="slug" id="slug" value="{{ $category->slug }}"
                                        readonly class="form-control" placeholder="Slug">
                                    <span class="text-danger" id='slugError'></span>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="image">Current Image</label>
                                    <img src="{{ asset('uploads/images/category/' . "$category->image") }}"
                                        alt="No image found" class="form-control" style="width:200px;height:120px;">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="image">New Image</label>
                                    <img src="" alt="Select an image" class="form-control"
                                        style="width:200px;height:120px;">
                                    <input type="file" name="image" id="image" accept="image/jpeg, image/jpg, image/png"> <br>
                                    <span class="text-danger" id='imageError'></span>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="status">Status</label>
                                    <select name="status" id="status" class="form-control">
                                        <option @if ($category->status == 1) selected @endif value="1">Active
                                            Category</option>
                                        <option @if ($category->status == 0) selected @endif value="0">Category
                                            Deactived</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="showHome">Show Home</label>
                                    <select name="showHome" id="showHome" class="form-control">
                                        <option @if ($category->showHome=='Yes') selected @endif value="Yes">Yes</option>
                                        <option @if ($category->showHome=='No') selected @endif value="No">No</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
                <div class="pb-5 pt-3">
                    <button type="submit" class="btn btn-primary">Update</button>
                    <a href="{{ route('category.index') }}" class="btn btn-outline-dark ml-3">Cancel</a>
                </div>
            </div>
            <!-- /.card -->
        </form>
    </section>

    <!-- /.content -->
@endsection


@section('custom_js')
    <script>
        $(document).ready(function() {

            //start for showing slug automaticaly
            $('#name').on('keyup', function() {
                let name = $(this).val();
                $('button[type=submit]').prop('disabled', true);
                $.ajax({
                    url: '{{ route('change.slug') }}',
                    method: 'get',
                    data: {
                        name: name
                    },
                    success: function(res) {
                        $('#slug').val(res);
                        $('button[type=submit]').prop('disabled', false);
                    }
                })
            })
            //end for showing slug automaticaly

            //start for update category

            $('#editCategoryForm').submit(function(e) {
                e.preventDefault();
                var formData = new FormData(this)

                $('#nameError').html('');
                $('#slugError').html('');
                $('#imageError').html('');
                $('#name').removeClass('is-invalid');
                $('#slug').removeClass('is-invalid');
                $('#image').removeClass('is-invalid');
                $.ajax({
                    url: '{{ route('category.update') }}',
                    method: 'post',
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(res) {
                       $('button[type=submit]').prop('disabled',true)
                       window.location.href="{{route('category.index')}}"
                    },
                    error: function(err) {
                        if (err.responseJSON.errors.name) {
                            $('#nameError').html(err.responseJSON.errors.name);
                            $('#name').addClass('is-invalid');
                        }

                        if (err.responseJSON.errors.slug) {
                            $('#slugError').html(err.responseJSON.errors.slug);
                            $('#slug').addClass('is-invalid');
                        }
                        if (err.responseJSON.errors.image) {
                            $('#imageError').html(err.responseJSON.errors.image);
                            $('#image').addClass('is-invalid');
                        }
                    }
                })

            })

            //end for edit category
        })
    </script>
@endsection
