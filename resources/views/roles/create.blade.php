@extends('layouts.app')

@section('title', 'Add Role')

@section('content')
    <div class="row page-titles">
        <div class="col-md-5 align-self-center">
            <h4 class="text-themecolor">Add Roles</h4>
        </div>
        <div class="col-md-7 align-self-center text-right">
            <div class="d-flex justify-content-end align-items-center">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                    <li class="breadcrumb-item active">Roles</li>
                    <li class="breadcrumb-item active">Add Role</li>
                </ol>
                <a href="{{ route('roles.index') }}" class="btn btn-info d-none d-lg-block m-l-15"><i
                        class="fa fa-plus-circle"></i> Back</a>
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
                    <h5 class="card-title">Create Role</h5>
                    {!! Form::open(['route' => 'roles.store', 'method' => 'POST', 'class' => 'form-material m-t-40 create']) !!}
                    <div class="form-group">
                        <div class="row">
                            <label class="col-sm-12">Name</label>
                            <div class="col-sm-12 validate">
                                {!! Form::text('name', null, ['placeholder' => 'Name', 'class' => 'form-control']) !!}
                            </div>
                        </div>
                    </div>
                    {{-- First Way --}}
                    <div class="form-group">
                        <div class="row">
                            <label class="col-sm-12">Permission</label>
                            <div class="col-sm-12 validate">
                                @foreach ($permissions->groupBy('category') as $category => $permissions)
                                    <h6 class="card-title mt-2">{{ $category }}</h6>
                                    <div class="row mt-2">
                                        @foreach ($permissions as $permission)
                                            <div class="col-md-3">
                                                <label class="checkbox-label">
                                                    {{ Form::checkbox('permission[]', $permission->id, false, ['class' => 'name']) }}
                                                    <span class="checkbox-text">{{ $permission->name }}</span>
                                                </label>
                                            </div>
                                        @endforeach
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                    {{-- End First Way --}}

                    {{-- Second Way --}}
                    {{-- <div class="form-group">
                        <div class="row">
                            <label class="col-sm-12">Permission</label>
                            <div class="col-sm-12 validate">
                                <div id="accordion">
                                    @foreach ($permissions->groupBy('category') as $index => $groupedPermissions)
                                        <?php $categoryId = str_replace(' ', '-', $groupedPermissions[0]->category); ?>
                                        <div class="card">
                                            <div class="card-header" id="heading{{ $categoryId }}">
                                                <h5 class="mb-0">
                                                    <button type="button" class="btn btn-link" data-toggle="collapse" data-target="#collapse{{ $categoryId }}" aria-expanded="true" aria-controls="collapse{{ $categoryId }}">
                                                        {{ $groupedPermissions[0]->category }}
                                                    </button>
                                                </h5>
                                            </div>
                                            <div id="collapse{{ $categoryId }}" class="collapse @if($index == 0) show @endif" aria-labelledby="heading{{ $categoryId }}" data-parent="#accordion">
                                                <div class="card-body">
                                                    <div class="row">
                                                        @foreach ($groupedPermissions as $permission)
                                                            <div class="col-md-3">
                                                                <label>{{ Form::checkbox('permission[]', $permission->id, false, ['class' => 'name']) }}
                                                                    {{ $permission->name }}</label>
                                                            </div>
                                                        @endforeach
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div> --}}
                    {{-- End Second Way --}}
                    <button type="submit" class="btn btn-info waves-effect waves-light m-r-10">Submit</button>
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
@endsection
