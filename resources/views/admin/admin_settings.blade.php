@extends('layouts.admin_layout.admin_layout')

@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0 text-dark">Settings</h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item active">Admin Settings</li>
                        </ol>
                    </div><!-- /.col -->
                </div><!-- /.row -->
            </div><!-- /.container-fluid -->
        </div>
        <!-- /.content-header -->

        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <!-- left column -->
                    <div class="col-md-6">
                        <!-- general form elements -->
                        <div class="card card-primary">
                            <div class="card-header">
                                <h3 class="card-title">Update Password</h3>
                            </div>

                            @if(Session::has("error_message"))
                                <div class="alert alert-danger alert-dismissible fade show mt-2" role="alert">
                                    {{ Session::get("error_message") }}
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
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

                            <!-- /.card-header -->
                            <!-- form start -->
                            <form role="form" method="post" action="{{ url('/admin/update-current-password') }}" name="updatePasswordForm" id="updatePasswordForm">@csrf
                                <div class="card-body">
                                    <?php /*
                                        <div class="form-group">
                                        <label for="exampleInputEmail1">Admin Name</label>
                                        <input type="text"class="form-control" value="{{ $adminDetails->name }}" placeholder="Enter Admin/Sub Admin Name" id="admin_name" name="admin_name">
                                    </div>
                                    */?>
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Admin Email</label>
                                        <input readonly class="form-control" id="exampleInputEmail1" value="{{ $adminDetails->email }}">
                                    </div>
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Admin Type</label>
                                        <input readonly class="form-control" id="exampleInputEmail1" value="{{ $adminDetails->type }}">
                                    </div>
                                    <div class="form-group">
                                        <label for="exampleInputPassword1">Current Password</label>
                                        <input type="password" required name="current_password" class="form-control" id="current_password" placeholder="Enter Current Password">
                                        <span id="checkCurrentpassword"></span>
                                    </div>
                                    <div class="form-group">
                                        <label for="exampleInputPassword1">New Password</label>
                                        <input type="password" required class="form-control" id="new_password" name="new_password" placeholder="Enter New Password">
                                    </div>
                                    <div class="form-group">
                                        <label for="exampleInputPassword1">Confirm New Password</label>
                                        <input type="password" required class="form-control" id="confirm_password" name="confirm_password" placeholder="Confirm New Password">
                                    </div>
                                </div>
                                <!-- /.card-body -->

                                <div class="card-footer">
                                    <button type="submit" class="btn btn-primary">Submit</button>
                                </div>
                            </form>
                        </div>
                        <!-- /.card -->
                    </div>
                    <!--/.col (left) -->
                </div>
                <!-- /.row -->
            </div><!-- /.container-fluid -->
        </section>
        <!-- /.content -->
    </div>
@endsection

