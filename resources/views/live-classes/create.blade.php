@extends('layouts.app')

@section('title', 'Add Live Class')

@section('content')
    <div class="row page-titles">
        <div class="col-md-5 align-self-center">
            <h4 class="text-themecolor">Add Live Class</h4>
        </div>
        <div class="col-md-7 align-self-center text-right">
            <div class="d-flex justify-content-end align-items-center">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                    <li class="breadcrumb-item active">Live Classes</li>
                    <li class="breadcrumb-item active">Add Live Class</li>
                </ol>
                <a href="{{ route('live-classes.index') }}" class="btn btn-info d-none d-lg-block m-l-15"><i class="fa fa-plus-circle"></i> Back</a>
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

                    <h5 class="card-title">Create Live Class</h5>
                    {!! Form::open(array('route' => 'live-classes.store','method'=>'POST', 'class' => 'form-material m-t-40 create')) !!}
                            <div class="form-group">
                                <div class="row">
                                    <label class="col-sm-12">Class</label>
                                    <div class="col-sm-12 validate">
                                        <select name="class_id" class="form-control" required>
                                            <option value="">Select Option</option>
                                            @foreach($classes as $c)
                                                <option value="{{ $c->id }}">{{ $c->name.' - '.$c->section->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="row">
                                    <label class="col-sm-12">Meeting Link</label>
                                    <div class="col-sm-12 validate">
                                        <input required type="text" name="meeting_link" placeholder="Web Link" class="form-control">
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
