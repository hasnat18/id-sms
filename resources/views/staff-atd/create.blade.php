@extends('layouts.app')

@section('title', 'Add Staff Attendance')

@section('content')
    <div class="row page-titles">
        <div class="col-md-5 align-self-center">
            <h4 class="text-themecolor">Add Staff Attendance</h4>
        </div>
        <div class="col-md-7 align-self-center text-right">
            <div class="d-flex justify-content-end align-items-center">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                    <li class="breadcrumb-item active">Staff Attendance</li>
                    <li class="breadcrumb-item active">Add Staff Attendance</li>
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

                    <h5 class="card-title">Create staff attendance</h5>
                    {!! Form::open(array('route' => 'staff-attendance.store','method'=>'POST', 'class' => 'form-material m-t-40 create')) !!}

                    <div class="form-group">
                        <div class="row">
                            <label class="col-sm-12">Staff</label>
                            <div class="col-sm-12 validate">
                                <select required name="staff_id" class="form-control">
                                    <option value="">select option</option>
                                    @foreach($staffs as $staff)
                                        <option value="{{$staff->id}}">{{ $staff->name.' - '.$staff->id }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <div class="col-sm-6">
                                <label class="col-sm-12">Time In</label>
                                <div class="col-sm-12 validate">
                                    <input type="time" name="time_in" class="form-control">
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <label class="col-sm-12">Time Out</label>
                                <div class="col-sm-12 validate">
                                    <input type="time" name="time_out" class="form-control">
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="row">
                            <label class="col-sm-12">Date</label>
                            <div class="col-sm-12 validate">
                                <input required type="date" name="add_at" class="form-control">
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <label class="col-sm-12">Status</label>
                            <div class="col-sm-12 validate">
                                <select required name="status" class="form-control">
                                    <option value="">select option</option>
                                    <option value="absent">Absent</option>
                                    <option value="present">Present</option>
                                    <option value="leave">Leave</option>
                                    <option value="late">Late</option>
                                </select>
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
