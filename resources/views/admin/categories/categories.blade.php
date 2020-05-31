@extends('layouts.admin_layout.admin_layout')

@section('content')
    <div class="content-wrapper">

        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Catalogues</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item active">Categories</li>
                        </ol>
                    </div>
                </div>
            </div><!-- /.container-fluid -->
        </section>
        <!-- Main content -->
        <section class="content">
            <div class="row">
                <div class="col-12">

                    @if(Session::has("success_message"))
                        <div class="alert alert-success alert-dismissible fade show mt-2" role="alert">
                            {{ Session::get("success_message") }}
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    @endif

                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Categories</h3>
                            <a href="{{ url('admin/add-edit-category/') }}" class="btn btn-success float-right">Add Category</a>
                        </div>

                    <!-- /.card-header -->
                        <div class="card-body">
                            <table id="categories" class="table table-bordered table-striped">
                                <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Section</th>
                                    <th>Parent Category</th>
                                    <th>Category</th>
                                    <th>URL</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                                </thead>
                                <tbody>

                                @foreach($categories as $category)
                                    <tr>
                                        <td>{{ $category->id }}</td>
                                        <td>{{ $category->section->name }}</td>
                                        <td>
                                            {{ !isset($category->parentcategory->category_name) ? 'Root' : $category->parentcategory->category_name }}
                                        </td>
                                        <td>{{ $category->category_name }}</td>
                                        <td>{{ $category->url }}</td>
                                        <td>
                                            @if($category->status == 1)
                                                <a class="updateCategoryStatus"
                                                   id="category-{{ $category->id }}"
                                                   category_id="{{ $category->id }}"
                                                   href="javascript:void(0)">
                                                    Active
                                                </a>
                                            @else
                                                <a class="updateCategoryStatus"
                                                   id="category-{{ $category->id }}"
                                                   category_id="{{ $category->id }}"
                                                   href="javascript:void(0)">
                                                    Inactive
                                                </a>
                                            @endif
                                        </td>
                                        <td>
                                            <a href="{{ url('admin/add-edit-category/'. $category->id) }}">Edit</a> |
                                            <a class="confirmDelete"
                                               record="category"
                                               recordId ="{{ $category->id }}"
                                               href="javascript:void(0)"
                                               <?php /*href="{{ url('admin/delete-category/'. $category->id) }} ">*/ ?>>
                                                Delete
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach

                                </tbody>
                            </table>
                        </div>
                        <!-- /.card-body -->
                    </div>
                    <!-- /.card -->
                </div>
                <!-- /.col -->
            </div>
            <!-- /.row -->
        </section>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
@endsection
