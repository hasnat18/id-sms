@extends('layouts.app')

@section('title', 'Edit User')

@section('content')
    <div class="row page-titles">
        <div class="col-md-5 align-self-center">
            <h4 class="text-themecolor">Edit User</h4>
        </div>
        <div class="col-md-7 align-self-center text-right">
            <div class="d-flex justify-content-end align-items-center">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                    <li class="breadcrumb-item active">Users</li>
                    <li class="breadcrumb-item active">Edit User</li>
                </ol>
                <a href="{{ route('users.index') }}" class="btn btn-info d-none d-lg-block m-l-15"><i class="fa fa-plus-circle"></i> Back</a>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-body">

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
                    <div class="alert alert-cyan">
                        <small>Password will be default <b>user1234</b></small>
                    </div>
                    <h5 class="card-title">Edit User</h5>

                    {!! Form::model($user, ['method' => 'PATCH','route' => ['users.update', $user->id],  'class' => 'form-material m-t-40 create' ]) !!}
                    <div class="form-group">
                        <div class="row">
                            <label class="col-sm-12">Name</label>
                            <div class="col-sm-12 validate">
                                {!! Form::text('name', null, array('placeholder' => 'Name','class' => 'form-control', 'required')) !!}
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <label class="col-sm-12">Email</label>
                            <div class="col-sm-12 validate">
                                {!! Form::email('email', null, array('placeholder' => 'Email','class' => 'form-control', 'required')) !!}
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="row">
                            <label class="col-sm-12">Role</label>
                            <div class="col-sm-12 validate">
                                {!! Form::select('roles', $roles,$userRole, array('class' => 'form-control','required')) !!}
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="row">
                            <label class="col-sm-12">Department</label> <small class="small-text">Current Department is {{ $userDep->name }}</small>
                            <div class="col-sm-12 validate">
                                {!! Form::select('department', $departments, $userDep, array('class' => 'form-control','required')) !!}
                            </div>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-info waves-effect waves-light m-r-10">Submit</button>
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
@endsection
