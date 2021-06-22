@extends('layouts.admin_layout.admin_layout')

@section('content')
    <!-- Content Wrapper. Contains page content -->
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
            <div class="container-fluid">

                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                @if(Session::has("success_message"))
                    <div class="alert alert-success alert-dismissible fade show mt-2" role="alert">
                        {{ Session::get("success_message") }}
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                @endif

                <form
                    name="productForm"
                    id="productForm"
                    @if(empty($categoryData['id']))
                    action="{{ url('admin/add-edit-product') }}"
                    @else
                    action="{{ url('admin/add-edit-product/'. $productData['id']) }}"
                    @endif
                    method="POST"
                    enctype="multipart/form-data">

                    @csrf
                    <div class="card card-default">
                        <div class="card-header">
                            <h3 class="card-title">{{ $title }}</h3>

                            <div class="card-tools">
                                <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
                                <button type="button" class="btn btn-tool" data-card-widget="remove"><i class="fas fa-remove"></i></button>
                            </div>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="catergory_id">Select Category</label>
                                        <select name="category_id" id="category_id" class="form-control select2" style="width: 100%;">
                                            <option value="">Select</option>
                                            @foreach($categories as $section)
                                                <optgroup label="{{ $section['name'] }}"></optgroup>
                                                @foreach($section['categories'] as $category)
                                                    <option value="{{ $category['id'] }}"
                                                            @if(!empty(@old('category_id')) && $category['id'] == @old('category_id')) selected="selected" @endif>
                                                        &nbsp;&nbsp;&nbsp;--&nbsp;&nbsp;{{ $category['category_name'] }}
                                                    </option>
                                                    @foreach($category['subcategories'] as $subcategory)
                                                        <option value="{{ $subcategory['id'] }}"
                                                                @if(!empty(@old('category_id')) && $subcategory['id'] == @old('category_id')) selected="selected" @endif>
                                                            &nbsp;&nbsp;&nbsp&nbsp;&nbsp;&nbsp;--&nbsp;&nbsp;{{ $subcategory['category_name'] }}
                                                        </option>
                                                    @endforeach
                                                @endforeach
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="product_name">Product Name</label>
                                        <input type="text"
                                               class="form-control"
                                               id="product_name"
                                               name="product_name"
                                               value="{{ empty($productData['product_name']) ? old('product_name') : $productData['product_name'] }}"
                                               placeholder="Enter Product Name">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="product_code">Product Code</label>
                                        <input type="text"
                                               class="form-control"
                                               id="product_code"
                                               name="product_code"
                                               value="{{ empty($productData['product_code']) ? old('product_code') : $productData['product_code'] }}"
                                               placeholder="Enter Product Code">
                                    </div>
                                    <div class="form-group">
                                        <label for="product_color">Product Color</label>
                                        <input type="text"
                                               class="form-control"
                                               id="product_color"
                                               name="product_color"
                                               value="{{ empty($productData['product_color']) ? old('product_color') : $productData['product_color'] }}"
                                               placeholder="Enter Product Color">
                                    </div>
                                </div>
                                <!-- /.col -->
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="product_price">Product Price</label>
                                        <input type="text"
                                               class="form-control"
                                               id="product_price"
                                               name="product_price"
                                               value="{{ empty($productData['product_price']) ? old('product_price') : $productData['product_price'] }}"
                                               placeholder="Enter Product Price">
                                    </div>
                                    <div class="form-group">
                                        <label for="product_discount">Product Discount (%)</label>
                                        <input type="text"
                                               class="form-control"
                                               id="product_discount"
                                               name="product_discount"
                                               value="{{ empty($productData['product_discount']) ? old('product_discount') : $productData['product_discount'] }}"
                                               placeholder="Enter Product Discount">
                                    </div>
                                </div>
                                <!-- /.col -->
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="product_weight">Product Weight</label>
                                        <input type="text"
                                               class="form-control"
                                               id="product_weight"
                                               name="product_weight"
                                               value="{{ empty($productData['product_weight']) ? old('product_weight') : $productData['product_weight'] }}"
                                               placeholder="Enter Product Weight">
                                    </div>
                                    <div class="form-group">
                                        <label for="main_image">Product Main Image</label>
                                        <div class="input-group">
                                            <div class="custom-file">
                                                <input type="file" class="custom-file-input" name="main_image" id=main_image">
                                                <label class="custom-file-label" for="product_image">Choose file</label>
                                            </div>
                                            <div class="input-group-append">
                                                <span class="input-group-text" id="">Upload</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- /.col -->
                            </div>
                            <!-- /.row -->
                            <div class="row">
                                <div class="col-12 col-sm-6">
                                    <div class="form-group">
                                        <label for="product_video">Product Video</label>
                                        <div class="input-group">
                                            <div class="custom-file">
                                                <input type="file" class="custom-file-input" name="product_video" id=product_video">
                                                <label class="custom-file-label" for="product_video">Choose file</label>
                                            </div>
                                            <div class="input-group-append">
                                                <span class="input-group-text" id="">Upload</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="description">Product Description</label>
                                        <textarea class="form-control" name="description" rows="3" placeholder="Enter Product Description">
                                            {{ empty($productData['description']) ? old('description') : $productData['description'] }}
                                        </textarea>
                                    </div>
                                </div>
                                <!-- /.col -->
                                <div class="col-12 col-sm-6">
                                    <div class="form-group">
                                        <label for="wash_care">Wash Care</label>
                                        <textarea class="form-control" name="wash_care" rows="3" placeholder="Enter Wash Care">
                                            {{ empty($productData['wash_care']) ? old('wash_care') : $productData['wash_care'] }}
                                        </textarea>
                                    </div>
                                    <div class="form-group">
                                        <label for="fabric">Select Fabric</label>
                                        <select name="fabric" id="fabric" class="form-control select2" style="width: 100%;">
                                            <option selected="selected" value="">Select</option>
                                            @foreach($fabricArray as $fabric)
                                                <option value="{{ $fabric }}">{{ $fabric }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-12 col-sm-6">
                                    <div class="form-group">
                                        <label for="sleeve">Select Sleeve</label>
                                        <select name="sleeve" id="sleeve" class="form-control select2" style="width: 100%;">
                                            <option selected="selected" value="">Select</option>
                                            @foreach($sleeveArray as $sleeve)
                                                <option value="{{ $sleeve }}">{{ $sleeve }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="pattern">Select Pattern</label>
                                        <select name="pattern" id="pattern" class="form-control select2" style="width: 100%;">
                                            <option selected="selected" value="">Select</option>
                                            @foreach($patternArray as $pattern)
                                                <option value="{{ $pattern }}">{{ $pattern }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="meta_title">Meta Title</label>
                                        <textarea class="form-control" name="meta_title" rows="3" placeholder="Enter Meta Title">
                                            {{ empty($productData['meta_title']) ? old('meta_title') : $productData['meta_title'] }}
                                        </textarea>
                                    </div>
                                </div>

                                <div class="col-12 col-sm-6">
                                    <div class="form-group">
                                        <label for="fit">Select Fit</label>
                                        <select name="fit" id="fit" class="form-control select2" style="width: 100%;">
                                            <option selected="selected" value="">Select</option>
                                            @foreach($fitArray as $fit)
                                                <option value="{{ $fit }}">{{ $fit }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="occassion">Select Occassion</label>
                                        <select name="occassion" id="occassion" class="form-control select2" style="width: 100%;">
                                            <option selected="selected" value="">Select</option>
                                            @foreach($occassionArray as $occassion)
                                                <option value="{{ $occassion }}">{{ $occassion }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="meta_description">Meta Description</label>
                                        <textarea class="form-control" name="meta_description" rows="3" placeholder="Enter Meta Description">
                                            {{ empty($productData['meta_description']) ? old('meta_description') : $productData['meta_description'] }}
                                        </textarea>
                                    </div>
                                </div>

                                <div class="col-12 col-sm-6">
                                    <div class="form-group">
                                        <label for="meta_keywords">Meta Keywords</label>
                                        <textarea class="form-control" name="meta_keywords" rows="3" placeholder="Enter Meta Keywords">
                                            {{ empty($productData['meta_keywords']) ? old('meta_keywords') : $productData['meta_keywords'] }}
                                        </textarea>
                                    </div>
                                    <div class="form-group">
                                        <label for="is_featured">Featured Item</label>
                                        <input type="checkbox" name="is_featured" id="is_featured" value="1">
                                    </div>
                                </div>
                                <!-- /.col -->
                            </div>
                            <!-- /.row -->
                        </div>
                        <!-- /.card-body -->
                        <div class="card-footer">
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </div>
                    </div>
                </form>
            </div><!-- /.container-fluid -->
        </section>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->

@endsection

