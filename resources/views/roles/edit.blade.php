@extends('layouts.app')

@section('title', 'Edit Role')

@section('content')
    <div class="row page-titles">
        <div class="col-md-5 align-self-center">
            <h4 class="text-themecolor">Edit Roles</h4>
        </div>
        <div class="col-md-7 align-self-center text-right">
            <div class="d-flex justify-content-end align-items-center">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                    <li class="breadcrumb-item active">Roles</li>
                    <li class="breadcrumb-item active">Edit Role</li>
                </ol>
                <a href="{{ route('roles.index') }}" class="btn btn-info d-none d-lg-block m-l-15"><i class="fa fa-plus-circle"></i> Back</a>
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

                    <h5 class="card-title">Edit Role</h5>

                    {!! Form::model($role, ['method' => 'PATCH','route' => ['roles.update', $role->id],
                        'class' => 'form-material m-t-40 create']) !!}

                        <div class="form-group">
                            <div class="row">
                                <label class="col-sm-12">Name</label>
                                <div class="col-sm-12 validate">
                                    {!! Form::text('name', null, array('placeholder' => 'Name','class' => 'form-control')) !!}
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="row">
                                <label class="col-sm-12">Permission</label>
                                <div class="col-sm-12 validate">
                                    @foreach ($permission->groupBy('category') as $category => $permission) 
                                    <h6 class="card-title mt-2">{{ $category }}</h6> 
                                    <div class="row">
                                        @foreach($permission as $value)
                                            <div class="col-md-3">
                                                <label>{{ Form::checkbox('permission[]', $value->id, in_array($value->id, $rolePermissions) ? true : false, array('class' => 'name')) }}
                                                    {{ $value->name }}</label>
                                            </div>
                                        @endforeach
                                    </div>
                                    @endforeach
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
