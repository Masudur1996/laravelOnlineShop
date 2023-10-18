@extends('admin.layout.master')

@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid my-2">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Create Category</h1>
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
        <form id="categoryForm">
            <!-- Default box -->
            <div class="container-fluid">
                <div class="card">
                    <div class="card-body">

                        <div class="row">
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
                                    <label for="slug">Slug</label>
                                    <input type="text" name="slug" id="slug" readonly class="form-control"
                                        placeholder="Slug">
                                    <span class="text-danger" id='slugError'></span>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="image">Image</label>
                                    <img src="" alt="Select an image" class="form-control" style="width:200px;height:120px;">
                                     <input type="file" name="image" id="image" accept="image/jpeg, image/jpg, image/png"> <br>
                                     <span class="text-danger" id='imageError'></span>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="status">Status</label>
                                    <select name="status" id="status" class="form-control">
                                        <option value="1">Active</option>
                                        <option value="0">Deactive</option>
                                    </select>
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

           // for add category
            $('#categoryForm').submit(function(e) {
                e.preventDefault();
                var formData=new FormData(this);
                // let name = $('#name').val()
                // let slug = $('#slug').val()
                // let status = $('#status').val()

                $('button[type=submit]').prop('disabled', true);
                $('#nameError').html('');
                $('#slugError').html('');
                $('#imageError').html('');

                $('#name').removeClass('is-invalid');
                $('#slug').removeClass('is-invalid');
                $('#image').removeClass('is-invalid');

                $.ajax({
                    url: "{{ route('category.store') }}",
                    method:'post',
                    data: formData,
                    processData:false,
                    contentType:false,
                    success: function(response) {
                        console.log(response)
                        $('button[type=submit]').prop('disabled', false);
                        window.location.href = "{{ route('category.index') }}"
                    },

                    error: function(err) {

                        $('button[type=submit]').prop('disabled', false);
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
            //for displaying slug

            $('#name').on('keyup', function() {
                let name = $(this).val();
                $('button[type=submit]').prop('disabled', true);
                $.ajax({
                    url: '{{ route('change.slug') }}',
                    type: 'get',
                    data: {
                        name: name
                    },
                    success: function(response) {
                        $('#slug').val(response)
                        $('button[type=submit]').prop('disabled', false);


                    }
                })

            })




        })
    </script>
@endsection
