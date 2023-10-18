@extends('admin.layout.master')

@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid my-2">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Create Sub Category</h1>
                </div>
                <div class="col-sm-6 text-right">
                    <a href="{{route('sub-category.index')}}" class="btn btn-primary">Back</a>
                </div>
            </div>
        </div>
        <!-- /.container-fluid -->
    </section>
    <!-- Main content -->
    <section class="content">
        <!-- Default box -->
        <form action="" id="subCategoryForm">
            <div class="container-fluid">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="category_id">Category Name</label>
                                    <select name="category_id" id="category_id" class="form-control">
                                        <option value="">Select a category</option>
                                        @foreach ($categories as $category)
                                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                                        @endforeach
                                    </select>
                                    <span class="text-danger" id='categoryIdError'></span>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="name">Name</label>
                                    <input type="text" name="name" id="name" class="form-control"
                                        placeholder="Name">
                                    <span class="text-danger" id='nameError'></span>
                                </div>

                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="email">Slug</label>
                                    <input type="text" name="slug" readonly id="slug" class="form-control"
                                        placeholder="Slug">
                                    <span class="text-danger" id='slugError'></span>
                                </div>

                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="email">Status</label>
                                    <select name="status" id="status" class="form-control">
                                        <option value="">Select a Status</option>
                                        <option value="1">Active</option>
                                        <option value="0">DeActive</option>
                                    </select>
                                    <span class="text-danger" id='statusError'></span>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="showHome">Show Home</label>
                                    <select name="showHome" id="showHome" class="form-control">
                                        <option value="Yes">Yes</option>
                                        <option value="No">No</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="pb-5 pt-3">
                    <button type="submit" class="btn btn-primary">Create</button>
                    <a href="{{route('sub-category.index')}}" class="btn btn-outline-dark ml-3">Cancel</a>
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

            //for slug update
            $("#name").keyup(function() {
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


            //for add Sub category
            $('#subCategoryForm').submit(function(e) {
                e.preventDefault();
                let formData = new FormData(this);

                $('button[type=submit]').prop('disabled', true);
                $('#categoryIdError').html('')
                $('#nameError').html('')
                $('#slugError').html('')
                $('#statusError').html('')

                $.ajax({
                    url: '{{ route('sub-category.store') }}',
                    method: 'post',
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(res) {
                        window.location.href= "{{route('sub-category.index')}}"

                    },
                    error: function(err) {
                        $('button[type=submit]').prop('disabled', false);
                        if (err.responseJSON.errors.category_id) {
                            $('#categoryIdError').html(err.responseJSON.errors.category_id);
                        }
                        if (err.responseJSON.errors.name) {
                            $('#nameError').html(err.responseJSON.errors.name)
                        }

                        if (err.responseJSON.errors.slug) {
                            $('#slugError').html(err.responseJSON.errors.slug)
                        }
                        if (err.responseJSON.errors.status) {
                            $('#statusError').html(err.responseJSON.errors.status)
                        }
                    }
                })
            })
        })
    </script>
@endsection
