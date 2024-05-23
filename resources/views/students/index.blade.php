@extends('layouts.app')

@section('title', 'Students')

@section('content')

    <div class="row page-titles">
        <div class="col-md-5 align-self-center">
            <h4 class="text-themecolor">All Students</h4>
        </div>
        <div class="col-md-7 align-self-center text-right">
            <div class="d-flex justify-content-end align-items-center">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                    <li class="breadcrumb-item active">All Students</li>
                </ol>
{{--                @can('student-create')--}}
{{--                    <a href="{{ route('students.create') }}" class="btn btn-info d-none d-lg-block m-l-15"><i class="fa fa-plus-circle"></i> Create New</a>--}}
{{--                @endcan--}}
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

                    <h5 class="card-title">Students list</h5>
                    <div class="table-responsive">
                        <table id="myTable" class="table table-striped">
                            <thead>
                            <tr>
                                <th width="100px">Session</th>
                                <th>Student Name</th>
                                <th>Student GR No</th>
                                <th>Student Roll No</th>
                                <th>Class</th>
                                <th>Section</th>
                                <th>Status</th>
                                <th>Created At</th>
                                <th width="280px">Action</th>
                            </tr>
                            </thead>
                            <tbody>
                                @foreach ($data as $key => $d)
                                    <tr>
                                        <td>{{ \Carbon\Carbon::parse($d->_session->start_date)->format('Y').' - '.
                                            \Carbon\Carbon::parse($d->_session->end_date)->format('Y') }}</td>
                                        <td>{{ $d->name }}</td>
                                        <td>{{ $d->admission->gr_no }}</td>
                                        <td>{{ $d->roll_no }}</td>
                                        <td>{{ $d->admission->_class->name }}</td>
                                        <td>{{ $d->admission->_class->section->name }}</td>
                                        <td>
                                            @if($d->status == 'active')
                                                <label class="label label-success">{{ $d->status }}</label>
                                            @else
                                                <label class="label label-danger">{{ $d->status }}</label>
                                            @endif
                                        </td>
                                        <td>{{ $d->created_at->format('M d, Y') }}</td>
                                        <td>
                                            <a class="btn btn-info" href="{{ route('students.show',$d->id) }}">Show</a>
                                            @can('student-delete')
                                                {!! Form::open(['method' => 'DELETE','route' => ['students.destroy', $d->id],'style'=>'display:inline']) !!}
                                                {!! Form::submit('Delete', ['class' => 'btn btn-danger']) !!}
                                                {!! Form::close() !!}
                                            @endcan
                                        </td>
{{--                                        <td>--}}
{{--                                            @can('class-edit')--}}
{{--                                                <a class="btn btn-primary" href="{{ route('students.edit',$d->id) }}">Edit</a>--}}
{{--                                            @endcan--}}

{{--                                        </td>--}}
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



