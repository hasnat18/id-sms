@extends('layouts.app')

@section('title', 'Student Attendance Edit')

@section('content')
    <div class="row page-titles">
        <div class="col-md-5 align-self-center">
            <h4 class="text-themecolor">Student Attendance Details</h4>
        </div>
        <div class="col-md-7 align-self-center text-right">
            <div class="d-flex justify-content-end align-items-center">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                    <li class="breadcrumb-item">Student Attendance</li>
                    <li class="breadcrumb-item active">Edit Student Attendance</li>
                </ol>
                <a href="{{ route('s_atd.list') }}" class="btn btn-info d-none d-lg-block m-l-15"><i class="fa fa-plus-circle"></i> Back</a>
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

                    <h5 class="card-title">Edit Student Attendance</h5>
                        <div class="row mt-4">
                            <h3 class="col-md-12 mb-2">Student Details Information</h3>
                            <div class="col-md-4"><p class="font-medium">Class : {{ $data->admission->_class->name.' - '.$data->admission->_class->section->name }}</p></div>
                            <div class="col-md-4"><p class="font-medium">Roll Number : {{ $data->admission->student->roll_no }}</p></div>
                            <div class="col-md-4"><p class="font-medium">Name : {{ $data->admission->student->name }}</p></div>
                            @if($data->attendence === 'present')
                                <div class="col-md-4"><p class="font-medium">Attendance : PRESENT</p></div>
                            @else
                                <div class="col-md-4"><p class="font-medium">Attendance : ABSENT</p></div>
                            @endif
                            <div class="col-md-4"><p class="font-medium">Date : {{ Carbon\Carbon::parse( $data->added_at )->format('M d, Y') }}</p></div>
                        </div>


                    {!! Form::model($data, array('route' => ['s_atd.update', $data->id],
                        'method'=>'PATCH', 'class' => 'form-material m-t-40 create' )) !!}

                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-4">
                                    <label class="col-sm-12">Change Status</label>
                                    <div class="col-sm-12 validate">
                                        <select name="attendence" required class="form-control">
                                            <option value="">Select Option</option>
                                            <option value="absent" {{ $data->attendence === 'absent' ? 'selected' : '' }}>Absent</option>
                                            <option value="present" {{ $data->attendence === 'present' ? 'selected' : '' }}>Present</option>
                                            <option value="leave" {{ $data->attendence === 'leave' ? 'selected' : '' }}>Leave</option>
                                        </select>
                                    </div>
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
