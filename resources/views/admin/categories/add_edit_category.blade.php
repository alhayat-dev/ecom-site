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
                            <li class="breadcrumb-item active">Categories</li>
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
                    name="categoryForm"
                    id="categoryForm"
                    @if(empty($categoryData['id']))
                        action="{{ url('admin/add-edit-category') }}"
                    @else
                        action="{{ url('admin/add-edit-category/'. $categoryData['id']) }}"
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
                                        <label for="category_name">Category Name</label>
                                        <input type="text"
                                               class="form-control"
                                               id="category_name"
                                               name="category_name"
                                               value="{{ empty($categoryData['category_name']) ? old('category_name') : $categoryData['category_name'] }}"
                                               placeholder="Enter Category Name">
                                    </div>

                                    <div id="appendCategoriesLevel">
                                        @include('admin.categories.append_categories_level')
                                    </div>

                                </div>
                                <!-- /.col -->
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="section_id">Select Section</label>
                                        <select name="section_id" id="section_id" class="form-control select2" style="width: 100%;">
                                            <option selected="selected" value="">Select</option>
                                            @foreach($sections as $section)
                                                <option value="{{ $section->id }}"
                                                    @if(!empty($categoryData['section_id']) && $categoryData['section_id'] === $section->id))
                                                        selected
                                                    @endif
                                                >
                                                    {{ $section->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="form-group">
                                        <label for="exampleInputFile">Category Image</label>
                                        <div class="input-group">
                                            <div class="custom-file">
                                                <input type="file" class="custom-file-input" name="category_image" id="category_image">
                                                <label class="custom-file-label" for="category_image">Choose file</label>
                                            </div>
                                            <div class="input-group-append">
                                                <span class="input-group-text" id="">Upload</span>
                                            </div>
                                        </div>

                                        @if(!empty($categoryData['category_image']))
                                            <div style="width: 80px; margin-top: 5px;">
                                                <img src="{{ asset('images/category_images/'. $categoryData['category_image']) }}"
                                                     alt="Category Image is missiing"
                                                     style="width: 50px; height: 50px;"> &nbsp;
                                                <a
                                                    class="confirmDelete"
                                                    record = "category-image"
                                                    recordId = "{{ $categoryData['id'] }}"
                                                    href="javascript:void(0)"
                                                    <?php /*href="{{ url('admin/delete-category-image/' . $categoryData['id']) }}"*/ ?>
                                                   style="display: block; width: 100px;">
                                                    Delete Image
                                                </a>
                                            </div>
                                        @endif

                                    </div>
                                </div>
                                <!-- /.col -->
                            </div>
                            <!-- /.row -->
                            <div class="row">
                                <div class="col-12 col-sm-6">
                                    <div class="form-group">
                                        <label for="category_discount">Category Discount</label>
                                        <input type="text"
                                               class="form-control"
                                               name="category_discount"
                                               value="{{ empty($categoryData['category_discount']) ? old('category_discount') : $categoryData['category_discount'] }}"
                                               id="category_discount"
                                               placeholder="Enter Category Discount">
                                    </div>

                                    <div class="form-group">
                                        <label for="description">Category Description</label>
                                        <textarea class="form-control" name="description" rows="3" placeholder="Enter Category Description">
                                            {{ empty($categoryData['description']) ? old('description') : $categoryData['description'] }}
                                        </textarea>
                                    </div>

                                    <div class="form-group">
                                        <label for="meta_description">Meta Description</label>
                                        <textarea class="form-control" name="meta_description" rows="3" placeholder="Enter Meta Description">
                                            {{ empty($categoryData['meta_description']) ? old('meta_description') : $categoryData['meta_description'] }}
                                        </textarea>
                                    </div>

                                </div>
                                <!-- /.col -->
                                <div class="col-12 col-sm-6">
                                    <div class="form-group">
                                        <label for="url">Category URL</label>
                                        <input type="text"
                                               class="form-control"
                                               name="url"
                                               id="url"
                                               value="{{ empty($categoryData['url']) ? old('url') : $categoryData['url'] }}"
                                               placeholder="Enter Category URL">
                                    </div>

                                    <div class="form-group">
                                        <label for="meta_title">Meta Title</label>
                                        <textarea class="form-control" name="meta_title" rows="3" placeholder="Enter Meta Title">
                                            {{ empty($categoryData['meta_title']) ? old('meta_title') : $categoryData['meta_title'] }}
                                        </textarea>
                                    </div>

                                    <div class="form-group">
                                        <label for="meta_keywords">Meta Keywords</label>
                                        <textarea class="form-control" name="meta_keywords" rows="3" placeholder="Enter Meta Keywords">
                                            {{ empty($categoryData['meta_keywords']) ? old('meta_keywords') : $categoryData['meta_keywords'] }}
                                        </textarea>
                                    </div>
                                    <!-- /.form-group -->
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
