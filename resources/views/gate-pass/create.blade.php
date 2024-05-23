@extends('layouts.app')
@section('title', 'Add Staff Attendance')

@section('content')
    <div class="row page-titles">
        <div class="col-md-5 align-self-center">
            <h4 class="text-themecolor">Gate Pass</h4>
        </div>
        <div class="col-md-7 align-self-center text-right">
            <div class="d-flex justify-content-end align-items-center">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                    <li class="breadcrumb-item active">Gate Pass</li>
                    <li class="breadcrumb-item active">Add Gate Pass</li>
                </ol>
                <a href="{{ route('staff-attendance.index') }}" class="btn btn-info d-none d-lg-block m-l-15"><i class="fa fa-plus-circle"></i> Back</a>
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

                    <h5 class="card-title">Create gate Pass</h5>
                    {!! Form::open(array('route' => 'gate-pass.store','method'=>'POST', 'class' => 'form-material m-t-40 create')) !!}

                        <div class="row">
                            <div class="col-sm-6 mb-4">
                                <label class="col-sm-12">Person Name</label>
                                <div class="col-sm-12 validate">
                                    <input type="text" name="name" required class="form-control">
                                </div>
                            </div>
                            <div class="col-sm-6 mb-4">
                                <label class="col-sm-12">Person Cell No</label>
                                <div class="col-sm-12 validate">
                                    <input type="text" name="phone_number" class="form-control">
                                </div>
                            </div>
                            <div class="col-sm-12 mb-4">
                                <label class="col-sm-12">Relation</label>
                                <div class="col-sm-12 validate">
                                    <input type="text" name="relation"  class="form-control">
                                </div>
                            </div>
                            <div class="col-sm-6 mb-4">
                                <label class="col-sm-12">CNIC No</label>
                                <div class="col-sm-12 validate">
                                    <input type="text" name="cnic"  class="form-control">
                                </div>
                            </div>
                            <div class="col-sm-6 mb-4">
                                <label class="col-sm-12">Address</label>
                                <div class="col-sm-12 validate">
                                    <input type="text" name="address" class="form-control">
                                </div>
                            </div>
                            <div class="col-sm-6 mb-4">
                                <label class="col-sm-12">Time In</label>
                                <div class="col-sm-12 validate">
                                    <input type="time" name="time_in" required class="form-control">
                                </div>
                            </div>
                            <div class="col-sm-6 mb-4">
                                <label class="col-sm-12">Time Out</label>
                                <div class="col-sm-12 validate">
                                    <input type="time" name="time_out" required class="form-control">
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
