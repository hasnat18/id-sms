@extends('layouts.app')

@section('title', 'Student Attendance')

@section('content')
    <div class="row page-titles">
        <div class="col-md-5 align-self-center">
            <h4 class="text-themecolor">All Student Attendance</h4>
        </div>
        <div class="col-md-7 align-self-center text-right">
            <div class="d-flex justify-content-end align-items-center">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                    <li class="breadcrumb-item active">All Student Attendance</li>
                </ol>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-body">

                    @if ($message = Session::get('success'))
                        <div class="alert alert-success">
                            <p>{{ $message }}</p>
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

                    <h5 class="card-title">All Student Attendance</h5>

                    <div class="table-responsive">

                        <table id="myTable" class="table table-striped">
                            <thead>
                            <tr>
                                <th>Class</th>
                                <th>Roll Number</th>
                                <th>Name</th>
                                <th>Attendance</th>
                                <th>Date</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                            <tbody>
                                @foreach($data as $d)
                                    <tr>
                                        <td>{{ $d->admission->_class->name.' - '.$d->admission->_class->section->name }}</td>
                                        <td>{{ $d->admission->student->roll_no }}</td>
                                        <td>{{ $d->admission->student->name }}</td>
                                        <td>
                                            @if($d->attendence === 'present')
                                                <label class="label label-success">Present</label>
                                            @else
                                                <label class="label label-danger">Absent</label>
                                            @endif
                                        </td>
                                        <td>{{ Carbon\Carbon::parse( $d->added_at )->format('M d, Y')  }}</td>
                                        <td>
                                            @can('s_att-edit')
                                                <a class="btn btn-primary" href="{{ route('s_atd.edit',$d->id) }}">Edit</a>
                                            @endcan
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
