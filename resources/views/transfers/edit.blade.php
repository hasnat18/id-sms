@extends('layouts.app')

@section('title', 'Transfer Update')

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
                    <li class="breadcrumb-item active">Update Transfer</li>
                </ol>
                <a href="{{ route('transfers.index') }}" class="btn btn-info d-none d-lg-block m-l-15"><i
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

                    <h5 class="card-title">Update Transfer</h5>


                    {!! Form::model($data, [
                        'route' => ['transfers.update', $data->id],
                        'method' => 'PATCH',
                        'class' => 'form-material m-t-40 create',
                        'enctype' => 'multipart/form-data',
                    ]) !!}

                    <div class="form-group">
                        <div class="row">
                            <label class="col-sm-12">Admitted Students</label>
                            <div class="col-sm-12 validate">
                                <input type="text" name="admission_id" class="form-control" required
                                    placeholder="Student Name" value="{{ $admission->student_name }}" readonly>

                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="row">
                            <label class="col-sm-12">School Name</label>
                            <div class="col-sm-12 validate">
                                <input type="text" name="school_name" class="form-control" required
                                    placeholder="School Name" value="{{ $data->school_name }}">
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="row">
                            <label class="col-sm-12">Class Name</label>
                            <div class="col-sm-12 validate">
                                <input type="text" name="class_name" class="form-control" required
                                    placeholder="Class Name" value="{{ $data->class_name }}">
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="row">
                            <label class="col-sm-12">Attached Document <small>(If any)</small></label>
                            <div class="col-sm-12 validate">
                                <input type="file" name="doc" class="form-control" accept="image/*">
                            </div>
                            @isset($data->doc)
                                <img src="{{ asset('uploads/transfers/' . $data->doc) }}"
                                    alt="{{ $admission->student_name }}'s docs" class="h-50 shadow-lg" width="100"
                                    height="100">
                            @endisset
                        </div>
                    </div>

                    <button type="submit" class="btn btn-info waves-effect waves-light m-r-10">Submit</button>
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>

@endsection
