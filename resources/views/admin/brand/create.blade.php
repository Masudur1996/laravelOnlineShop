@extends('admin.layout.master')

@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid my-2">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Create Brand</h1>
                </div>
                <div class="col-sm-6 text-right">
                    <a href="{{ route('brand.index') }}" class="btn btn-primary">Back</a>
                </div>
            </div>
        </div>
        <!-- /.container-fluid -->
    </section>
    <!-- Main content -->
    <form action="" id="addBrandForm" method="post">
        <section class="content">
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
                                    <span class="text-danger" id="errorName"></span>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="slug">Slug</label>
                                    <input type="text" name="slug" id="slug" class="form-control"
                                        placeholder="Slug">
                                    <span class="text-danger" id="errorSlug"></span>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="status">Status</label>
                                    <select name="status" id="status" class="form-control">
                                        <option value="">Select a status</option>
                                        <option value="1">Active</option>
                                        <option value="0">Deactive</option>
                                    </select>
                                    <span class="text-danger" id="errorStatus"></span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="pb-5 pt-3">
                    <button type="submit" class="btn btn-primary">Create</button>
                    <a href="{{ route('brand.index') }}" class="btn btn-outline-dark ml-3">Cancel</a>
                </div>
            </div>
            <!-- /.card -->
        </section>
    </form>
    <!-- /.content -->
@endsection


@section('custom_js')
    <script>
        $(document).ready(function() {
            $('#addBrandForm').submit(function(e) {
                e.preventDefault();
                let formData = new FormData(this);
                $('button[type=submit]').prop('disabled', true)
                $('#errorName').html('')
                $("#name").removeClass('is-invalid')
                $('#errorSlug').html('')
                $("#slug").removeClass('is-invalid')
                $('#errorStatus').html('')
                $("#status").removeClass('is-invalid')
                $.ajax({
                    url: '{{ route('brand.store') }}',
                    method: 'post',
                    data: formData,
                    contentType: false,
                    processData: false,
                    success: function(res) {
                        window.location.href='{{route('brand.index')}}';
                    },
                    error: function(err) {
                        $('button[type=submit]').prop('disabled', false)
                        if (err.responseJSON.errors.name) {
                            $('#errorName').html(err.responseJSON.errors.name)
                            $("#name").addClass('is-invalid')
                        }
                        if (err.responseJSON.errors.slug) {
                            $('#errorSlug').html(err.responseJSON.errors.slug)
                            $("#slug").addClass('is-invalid')
                        }
                        if (err.responseJSON.errors.status) {
                            $('#errorStatus').html(err.responseJSON.errors.status)
                            $("#status").addClass('is-invalid')
                        }
                    }
                })
            })

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
        })
    </script>
@endsection
