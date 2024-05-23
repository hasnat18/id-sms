@extends('layouts.app')

@section('title', 'My Profile')

@section('content')

    <div class="row page-titles">
        <div class="col-md-5 align-self-center">
            <h4 class="text-themecolor">My Profile</h4>
        </div>
        <div class="col-md-7 align-self-center text-right">
            <div class="d-flex justify-content-end align-items-center">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                    <li class="breadcrumb-item active">Users</li>
                    <li class="breadcrumb-item active">My Profile</li>
                </ol>
                <a href="{{ route('users.index') }}" class="btn btn-info d-none d-lg-block m-l-15"><i class="fa fa-plus-circle"></i> Back</a>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-body">

                    @if ($message = Session::get('success'))
                        <div class="alert alert-success">
                            <p>{{ $message }}</p>
                        </div>
                    @endif

                    @if (count($errors) > 0)
                        <div class="alert alert-danger">
                            <strong>Whoops!</strong> There were some problems with your input.<br><br>
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    @if (Session::get('error'))
                        <div class="alert alert-danger">
                            <strong>Whoops!</strong> There were some problems with your input.<br><br>
                            <ul>
                                <p>{{ Session::get('error') }}</p>
                            </ul>
                        </div>
                    @endif

                    <h5 class="card-title">Change Details</h5>
                        <form action="{{ route('users.profile.change') }}" method="POST" class="form-material m-t-40 create">
                            @csrf
                            <div class="form-group">
                                <div class="row">
                                    <label class="col-sm-12">Name</label>
                                    <div class="col-sm-12 validate">
                                        <input type="text" required class="form-control" placeholder="Name" value="{{ Auth::user()->name }}" name="name">
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="row">
                                    <label class="col-sm-12">Email</label>
                                    <div class="col-sm-12 validate">
                                        <input type="email" readonly required class="form-control" placeholder="Email" value="{{ Auth::user()->email }}" name="email">
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="row">
                                    <label class="col-sm-12">Current Password</label>
                                    <div class="col-sm-12 validate">
                                        <input type="password" required class="form-control" placeholder="Current Password" name="current_password">
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="row">
                                    <label class="col-sm-12">New Password</label>
                                    <div class="col-sm-12 validate">
                                        <input type="password" class="form-control" placeholder="New Password" name="new_password">
                                    </div>
                                </div>
                            </div>
                            <button type="submit" class="btn btn-info waves-effect waves-light m-r-10">Submit</button>
                        </form>
                </div>
            </div>
        </div>
    </div>


@endsection
