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
                            <li class="breadcrumb-item active">Products</li>
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
                            <a href="{{ url('admin/add-edit-product/') }}" class="btn btn-success float-right">Add Product</a>
                        </div>

                        <!-- /.card-header -->
                        <div class="card-body">
                            <table id="products" class="table table-bordered table-striped">
                                <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Product Name</th>
                                    <th>Product Code</th>
                                    <th>Product Color</th>
                                    <th>Category</th>
                                    <th>Section</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                                </thead>
                                <tbody>

                                @foreach($products as $product)
                                    <tr>
                                        <td>{{ $product->id }}</td>
                                        <td>{{ $product->product_name }}</td>
                                        <td>{{ $product->product_code }}</td>
                                        <td>{{ $product->product_color }}</td>
                                        <td>{{ $product->category->category_name }}</td>
                                        <td>{{ $product->section->name }}</td>
                                        <td>
                                            @if($product->status == 1)
                                                <a class="updateProductStatus" id="product-{{ $product->id }}" product_id="{{ $product->id }}"
                                                   href="javascript:void(0)">Active</a>
                                            @else
                                                <a class="updateProductStatus" id="product-{{ $product->id }}" product_id="{{ $product->id }}"
                                                   href="javascript:void(0)">Inactive</a>
                                            @endif
                                        </td>
                                        <td>
                                            <a href="{{ url('admin/add-edit-product/'. $product->id) }}">Edit</a> |
                                            <a class="confirmDelete" record="product" recordId ="{{ $product->id }}" href="javascript:void(0)"
                                            <?php /*href="{{ url('admin/delete-category/'. $product->id) }} ">*/ ?>>
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
