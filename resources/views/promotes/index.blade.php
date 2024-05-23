@extends('layouts.app')

@section('title', 'Promoted Students')

@section('content')
    <div class="row page-titles">
        <div class="col-md-5 align-self-center">
            <h4 class="text-themecolor">All Promoted Students</h4>
        </div>
        <div class="col-md-7 align-self-center text-right">
            <div class="d-flex justify-content-end align-items-center">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                    <li class="breadcrumb-item active">All Promoted Students</li>
                </ol>
                @can('promote-create')
                    <a href="{{ route('promotes.create') }}" class="btn btn-info d-none d-lg-block m-l-15"><i class="fa fa-plus-circle"></i> Create New</a>
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

                    <h5 class="card-title">All Promoted Students</h5>
                    <div class="table-responsive">
                        <table id="myTable" class="table table-striped">
                            <thead>
                            <tr>
                                <th>No</th>
                                <th>Class Name</th>
                                <th>Roll No</th>
                                <th>Student Name</th>
                                <th>Promoted Status</th>
                                <th>Status</th>
                                <th width="280px">Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach ($data as $key => $d)
                                <tr>
                                    <td>{{ ($key+1) }}</td>
                                    <td>{{ $d->class_name.' - '.$d->section_name  }}</td>
                                    <td>{{ $d->roll_no  }}</td>
                                    <td>{{ $d->name  }}</td>
                                    <td>{{ $d->promoted_or_demoted  }}</td>
                                    <td>{{ $d->status  }}</td>
                                    <td>
                                        <a class="btn btn-info" href="{{ route('promotes.show',$d->id) }}">Show</a>
                                        @can('promote-edit')
                                            <a class="btn btn-primary" href="{{ route('promotes.edit',$d->id) }}">Edit</a>
                                        @endcan
                                        @can('promote-delete')
                                            {!! Form::open(['method' => 'DELETE','route' => ['promotes.destroy', $d->id],'style'=>'display:inline']) !!}
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
