@extends('layouts.app')

@section('title', 'Add Transport')

@section('content')
    <div class="row page-titles">
        <div class="col-md-5 align-self-center">
            <h4 class="text-themecolor">Add Transport</h4>
        </div>
        <div class="col-md-7 align-self-center text-right">
            <div class="d-flex justify-content-end align-items-center">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                    <li class="breadcrumb-item active">Transports</li>
                    <li class="breadcrumb-item active">Add Transport</li>
                </ol>
                <a href="{{ route('transports.index') }}" class="btn btn-info d-none d-lg-block m-l-15"><i class="fa fa-plus-circle"></i> Back</a>
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

                    <h5 class="card-title">Create Transport</h5>
                    {!! Form::open(array('route' => 'transports.store','method'=>'POST', 'class' => 'form-material m-t-40 create')) !!}
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-6">
                                        <label class="col-sm-12">Vehicle Number</label>
                                        <div class="col-sm-12 validate">
                                            {!! Form::text('vehicle_number', null, array('placeholder' => 'Vehicle Number', 'class' => 'form-control', 'required')) !!}
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="col-sm-12">Vehicle Model</label>
                                        <div class="col-sm-12 validate">
                                            {!! Form::text('vehicle_model', null, array('placeholder' => 'Vehicle Model', 'class' => 'form-control', 'required')) !!}
                                        </div>
                                    </div>

                                </div>
                            </div>

                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-6">
                                        <label class="col-sm-12">Driver Name</label>
                                        <div class="col-sm-12 validate">
                                            {!! Form::text('driver_name', null, array('placeholder' => 'Driver Name', 'class' => 'form-control', 'required')) !!}
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="col-sm-12">Driver Phone</label>
                                        <div class="col-sm-12 validate">
                                            {!! Form::text('driver_phone', null, array('placeholder' => 'Driver Phone', 'class' => 'form-control', 'required')) !!}
                                        </div>
                                    </div>

                                </div>
                            </div>

                            <div class="form-group">
                                <div class="row">
                                    <label class="col-sm-12">Note</label>
                                    <div class="col-sm-12 validate">
                                        {!! Form::textarea('note', null, array('placeholder' => 'Note','class' => 'form-control')) !!}
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
