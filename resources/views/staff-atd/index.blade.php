@extends('layouts.app')

@section('title', 'Staff Attendance')

@section('content')

    <div class="row page-titles">
        <div class="col-md-5 align-self-center">
            <h4 class="text-themecolor">All Staff Attendance</h4>
        </div>
        <div class="col-md-7 align-self-center text-right">
            <div class="d-flex justify-content-end align-items-center">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                    <li class="breadcrumb-item active">All Staff Attendance</li>
                </ol>
                @can('st_atd-create')
                    <a href="{{ route('staff-attendance.create') }}" class="btn btn-info d-none d-lg-block m-l-15"><i class="fa fa-plus-circle"></i> Create New</a>
                @endcan
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

                    <h5 class="card-title">Staff Attendance list</h5>
                    <div class="table-responsive">
                        <table id="myTable" class="table table-striped">
                            <thead>
                            <tr>
                                <th>No</th>
                                <th>Name</th>
                                <th>Time In</th>
                                <th>Time Out</th>
                                <th>Added At</th>
                                <th>Status</th>
                                <th width="280px">Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach ($data as $key)
                                <tr>
                                    <td>{{ $key->id }}</td>
                                    <td>{{ $key->staff->name }}</td>
                                    <td>{{ \Carbon\Carbon::parse($key->time_in)->format('h-m a')  }}</td>
                                    <td>{{ \Carbon\Carbon::parse($key->time_out)->format('h-m a') }}</td>
                                    <td>{{ \Carbon\Carbon::parse($key->add_at)->format('M d, Y') }}</td>
                                    <td>
                                        @if($key->status === 'present')
                                            <label class="label label-success">Present</label>
                                        @elseif($key->status === 'leave')
                                            <label class="label label-warning">Leave</label>
                                        @elseif($key->status === 'late')
                                            <label class="label label-megna">Late</label>
                                        @else
                                            <label class="label label-danger">Absent</label>
                                        @endif
                                    </td>
                                    <td>
                                        @can('st_atd-edit')
                                            <a class="btn btn-primary" href="{{ route('staff-attendance.edit',$key->id) }}">Edit</a>
                                        @endcan
                                        @can('st_atd-delete')
                                            {!! Form::open(['method' => 'DELETE','route' => ['staff-attendance.destroy', $key->id],'style'=>'display:inline']) !!}
                                            {!! Form::submit('Delete', ['class' => 'btn btn-danger']) !!}
                                            {!! Form::close() !!}
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



