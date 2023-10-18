@extends('admin.layout.master')

@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid my-2">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Edit Sub Category</h1>
                </div>
                <div class="col-sm-6 text-right">
                    <a href="{{ route('sub-category.index') }}" class="btn btn-primary">Back</a>
                </div>
            </div>
        </div>
        <!-- /.container-fluid -->
    </section>
    <!-- Main content -->
    <section class="content">
        <!-- Default box -->
        <form action="" id="editSubCategoryForm">
            <div class="container-fluid">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <input type="hidden" name="id" id="id" value="{{ $subCategory->id }}">
                                <div class="mb-3">
                                    <label for="category_id">Category Name</label>
                                    <select name="category_id" id="category_id" class="form-control">
                                        <option value="">Select a category</option>
                                        @foreach ($categories as $category)
                                            <option @if ($subCategory->category_id == $category->id) selected @endif
                                                value="{{ $category->id }}">{{ $category->name }}</option>
                                        @endforeach
                                    </select>
                                    <span class="text-danger" id='categoryIdError'></span>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="name">Name</label>
                                    <input type="text" name="name" id="name" value="{{ $subCategory->name }}"
                                        class="form-control" placeholder="Name">
                                    <span class="text-danger" id='nameError'></span>
                                </div>

                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="email">Slug</label>
                                    <input type="text" name="slug" readonly id="slug"
                                        value="{{ $subCategory->slug }}" class="form-control" placeholder="Slug">
                                    <span class="text-danger" id='slugError'></span>
                                </div>

                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="email">Status</label>
                                    <select name="status" id="status" class="form-control">
                                        <option value="">Select a Status</option>

                                        <option @if ($subCategory->status == '1') selected @endif value="1">Active
                                        </option>
                                        <option @if ($subCategory->status == '0') selected @endif value="0">DeActive
                                        </option>
                                    </select>
                                    <span class="text-danger" id='statusError'></span>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="showHome">Show Home</label>
                                    <select name="showHome" id="showHome" class="form-control">
                                        <option @if ($subCategory->showHome=='Yes') selected @endif value="Yes">Yes</option>
                                        <option @if ($subCategory->showHome=='No') selected @endif value="No">No</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="pb-5 pt-3">
                    <button type="submit" class="btn btn-primary">Update</button>
                    <a href="{{ route('sub-category.index') }}" class="btn btn-outline-dark ml-3">Cancel</a>
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

            //for changer slug
            $('#name').keyup(function() {
                let name = $(this).val();
                $('button[type=submit]').prop('disabled', true);
                $.ajax({
                    url: '{{ route('change.slug') }}',
                    method: 'get',
                    data: {
                        name: name
                    },
                    success: function(res) {
                        $('button[type=submit]').prop('disabled', false);
                        $('#slug').val(res)
                    }
                })
            })

            //for update sub catgory
            $('#editSubCategoryForm').submit(function(e) {
                e.preventDefault();
                let formData = new FormData(this)

                $('#nameError').html('')
                $('#slugError').html('')
                $('#statusError').html('')
                $('#categoryIdError').html('')
                $('button[type=submit]').prop('disabled', true);
                $.ajax({
                    url: '{{ route('sub-category.update') }}',
                    method: 'post',
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(res) {
                        window.location.href = '{{ route('sub-category.index') }}'
                    },
                    error: function(err) {
                        $('button[type=submit]').prop('disabled', false);
                        if (err.responseJSON.errors.name) {
                            $('#nameError').html(err.responseJSON.errors.name)
                        }
                        if (err.responseJSON.errors.slug) {
                            $('#slugError').html(err.responseJSON.errors.slug)
                        }
                        if (err.responseJSON.errors.status) {
                            $('#statusError').html(err.responseJSON.errors.status)
                        }
                        if (err.responseJSON.errors.category_id) {
                            $('#categoryIdError').html(err.responseJSON.errors.category_id)
                        }
                    }
                })
            })
        })
    </script>
@endsection
