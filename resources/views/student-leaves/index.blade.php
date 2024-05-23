@extends('layouts.app')

@section('title', 'Student Leaves')

@section('content')

    <div class="row page-titles">
        <div class="col-md-5 align-self-center">
            <h4 class="text-themecolor">All Student Leaves</h4>
        </div>
        <div class="col-md-7 align-self-center text-right">
            <div class="d-flex justify-content-end align-items-center">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                    <li class="breadcrumb-item active">All Student Leaves</li>
                </ol>
                @can('student-leave-create')
                    <a href="{{ route('student-leaves.create') }}" class="btn btn-info d-none d-lg-block m-l-15"><i class="fa fa-plus-circle"></i> Create New</a>
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

                    <h5 class="card-title">Student Leaves list</h5>
                    <div class="table-responsive">
                        <table id="myTable" class="table table-striped">
                            <thead>
                            <tr>
                                <th>No</th>
                                <th>Class Name</th>
                                <th>Student Name</th>
                                <th>Start Date</th>
                                <th>End Date</th>
                                <th>Reason</th>
                                <th>Status</th>
                                <th width="280px">Action</th>
                            </tr>
                            </thead>
                            <tbody>
                                @foreach ($data as $key => $d)
                                    <tr>
                                        <td>{{ $d->id }}</td>
                                        <td>{{ $d->student->_class->name.' - '.$d->student->_class->section->name }}</td>
                                        <td>{{ $d->student->name }}</td>
                                        <td>{{ \Carbon\Carbon::parse($d->start_date)->format('M d, Y')  }}</td>
                                        <td>{{ \Carbon\Carbon::parse($d->end_date)->format('M d, Y')  }}</td>
                                        <td>{{ $d->reason }}</td>
                                        <td>{{ $d->status }}</td>
                                        <td>
                                            <a class="btn btn-info" href="{{ route('student-leaves.show',$d->id) }}">Show</a>
                                            @can('student-leave-edit')
                                                <a class="btn btn-primary" href="{{ route('student-leaves.edit',$d->id) }}">Edit</a>
                                            @endcan
                                            @can('student-leave-delete')
                                                {!! Form::open(['method' => 'DELETE','route' => ['student-leaves.destroy', $d->id],'style'=>'display:inline']) !!}
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



