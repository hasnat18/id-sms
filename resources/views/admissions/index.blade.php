@extends('layouts.app')

@section('title', 'Admissions')

@section('content')
    <div class="row page-titles">
        <div class="col-md-5 align-self-center">
            <h4 class="text-themecolor">All Admissions</h4>
        </div>
        <div class="col-md-7 align-self-center text-right">
            <div class="d-flex justify-content-end align-items-center">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                    <li class="breadcrumb-item active">All Admissions</li>
                </ol>
                @can('admission-create')
                    <a href="{{ route('admission.create') }}" class="btn btn-info d-none d-lg-block m-l-15"><i class="fa fa-plus-circle"></i> Create New</a>
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

                    <h5 class="card-title">Admissions list</h5>
                    <div class="alert alert-warning">
                        <p>If admission record is deleted everything that is attached to that admission will be deleted also.</p>
                    </div>
                    <div class="table-responsive">
                        <table id="myTable" class="table table-striped">
                            <thead>
                            <tr>
                                <th>No</th>
                                <th width="200px">Student Name</th>
                                <th>Gender</th>
                                <th width="200px">Date of birth</th>
                                <th width="200px">Address</th>
                                <th>City</th>
                                <th>State / Province</th>
                                <th>Class</th>
                                <th width="200px">Submitted At</th>
                                <th>Status</th>
                                <th width="280px">Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach ($data as $key => $d)
                                <tr>
                                    <td>{{ $d->id }}</td>
                                    <td>{{ $d->student_name }}</td>
                                    <td>{{ $d->gender }}</td>
                                    <td>{{ $d->dob }}</td>
                                    <td>{{ $d->address }}</td>
                                    <td>{{ $d->city }}</td>
                                    <td>{{ $d->state }}</td>
                                    <td>{{ $d->_class->name." - ".$d->_class->section->name }}</td>
                                    <td>{{ $d->created_at->format('M d, Y h:m:s') }}</td>
                                    <td>
                                        @if($d->status == 'pending' || $d->status == 'transferred')
                                            <label class="label label-warning">{{ ucwords($d->status) }}</label>
                                        @elseif($d->status == 'admitted')
                                            <label class="label label-success">{{ ucwords($d->status) }}</label>
                                        @elseif($d->status == 'cancelled')
                                            <label class="label label-danger">{{ ucwords($d->status) }}</label>
                                        @endif
                                    </td>
                                    <td>
                                        @can('admission-edit')
                                            <a class="btn btn-primary" href="{{ route('admission.edit',$d->id) }}">Edit</a>
                                        @endcan
                                        @can('admission-delete')
                                            {!! Form::open(['method' => 'DELETE','route' => ['admission.destroy', $d->id],'style'=>'display:inline']) !!}
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
