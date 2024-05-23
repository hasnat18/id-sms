@extends('layouts.app')

@section('title', 'Edit Staff Attendance')

@section('content')
    <div class="row page-titles">
        <div class="col-md-5 align-self-center">
            <h4 class="text-themecolor">Edit Staff Attendance</h4>
        </div>
        <div class="col-md-7 align-self-center text-right">
            <div class="d-flex justify-content-end align-items-center">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                    <li class="breadcrumb-item active">Staff Attendance</li>
                    <li class="breadcrumb-item active">Edit Staff Attendance</li>
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

                    <h5 class="card-title">Update staff attendance</h5>
                    {!! Form::model($data, array('route' => ['staff-attendance.update', $data->id],'method'=>'patch', 'class' => 'form-material m-t-40 create')) !!}

                    <div class="form-group">
                        <div class="row">
                            <label class="col-sm-12">Staff</label>
                            <div class="col-sm-12 validate">
                                <select required name="staff_id" class="form-control" disabled>
                                    <option value="">select option</option>
                                    @foreach($staffs as $staff)
                                        <option value="{{$staff->id}}" {{ $data->staff_id === $staff->id ? 'selected' : '' }}>{{ $staff->name.' - '.$staff->id }}</option>
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
                                    <input type="time" name="time_in" class="form-control" value="{{ $data->time_in }}">
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <label class="col-sm-12">Time Out</label>
                                <div class="col-sm-12 validate">
                                    <input type="time" name="time_out" class="form-control" value="{{ $data->time_out }}">
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="row">
                            <label class="col-sm-12">Date</label>
                            <div class="col-sm-12 validate">
                                <input disabled required type="date" name="add_at" class="form-control" value="{{ $data->add_at }}">
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <label class="col-sm-12">Status</label>
                            <div class="col-sm-12 validate">
                                <select required name="status" class="form-control">
                                    <option value="">select option</option>
                                    <option value="absent" {{ $data->status === 'absent' ? 'selected' : '' }}>Absent</option>
                                    <option value="present" {{ $data->status === 'present' ? 'selected' : '' }}>Present</option>
                                    <option value="leave" {{ $data->status === 'leave' ? 'selected' : '' }}>Leave</option>
                                    <option value="late" {{ $data->status === 'late' ? 'selected' : '' }}>Late</option>
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
