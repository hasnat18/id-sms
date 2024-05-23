@extends('layouts.app')

@section('title', 'Transfer Create')

@section('content')
    <div class="row page-titles">
        <div class="col-md-5 align-self-center">
            <h4 class="text-themecolor">Transfer Details</h4>
        </div>
        <div class="col-md-7 align-self-center text-right">
            <div class="d-flex justify-content-end align-items-center">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                    <li class="breadcrumb-item">Transfers</li>
                    <li class="breadcrumb-item active">Create Transfer</li>
                </ol>
                <a href="{{ route('transfers.index') }}" class="btn btn-info d-none d-lg-block m-l-15"><i class="fa fa-plus-circle"></i> Back</a>
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

                    <h5 class="card-title">Create Transfer</h5>


                    {!! Form::open(array('route' => 'transfers.store','method'=>'POST', 'class' => 'form-material m-t-40 create', 'enctype' => 'multipart/form-data')) !!}

                        <div class="form-group">
                            <div class="row">
                                <label class="col-sm-12">Admitted Students</label>
                                <div class="col-sm-12 validate">
                                    <select name="admission_id" class="form-control" required>
                                        <option value="">Select Option</option>
                                        @foreach($admissions as $a)
                                            <option value="{{ $a->id }}">{{ $a->id." - ".$a->student_name." - ".$a->_class->name." - ".$a->_class->section->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="row">
                                <label class="col-sm-12">School Name</label>
                                <div class="col-sm-12 validate">
                                    <input type="text" name="school_name" class="form-control" required placeholder="School Name">
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="row">
                                <label class="col-sm-12">Class Name</label>
                                <div class="col-sm-12 validate">
                                    <input type="text" name="class_name" class="form-control" required placeholder="Class Name">
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="row">
                                <label class="col-sm-12">Attached Document <small>(If any)</small></label>
                                <div class="col-sm-12 validate">
                                    <input type="file" name="doc" class="form-control" accept="image/*">
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
