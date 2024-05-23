@extends('layouts.app')

@section('title', 'Results')

@section('content')
    <div class="row page-titles">
        <div class="col-md-5 align-self-center">
            <h4 class="text-themecolor">Results</h4>
        </div>
        <div class="col-md-7 align-self-center text-right">
            <div class="d-flex justify-content-end align-items-center">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                    <li class="breadcrumb-item active">Results</li>
                </ol>
                @can('result-create')
                    <a href="{{ route('results.create') }}" class="btn btn-info d-none d-lg-block m-l-15"><i class="fa fa-plus-circle"></i> Create New</a>
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

                    <h5 class="card-title">Examination</h5>

                    <div class="table-responsive">
                        <table id="myTable" class="table table-striped">
                            <thead>
                            <tr>
                                <th>No</th>
                                <th>Class</th>
                                <th>Student</th>
                                <th>Exam Type</th>
                                <th>Total Marks</th>
                                <th>Obtained Marks</th>
                                <th>Percentage</th>
                                <th>Grade</th>
                                <th>Status</th>
                                <th width="280px">Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach ($data as $key => $d)
                                <tr>
                                    <td>{{ $d->id }}</td>
                                    <td>{{ $d->__class->name.' - '.$d->__class->section->name }}</td>
                                    <td>{{ $d->__class->student->name }}</td>
                                    <td>{{ $d->exam_type }}</td>
                                    <td>{{ $d->total_marks }}</td>
                                    <td>{{ $d->obtained_marks }}</td>
                                    <td>{{ $d->percentage }}</td>
                                    <td>{{ $d->grade }}</td>
                                    <td>{{ $d->status }}</td>
                                    <td>
                                        <a class="btn btn-info" href="{{ route('results.show',$d->id) }}">Show</a>
                                        @can('result-edit')
                                            <a class="btn btn-primary" href="{{ route('results.edit',$d->id) }}">Edit</a>
                                        @endcan
                                        @can('result-delete')
                                            {!! Form::open(['method' => 'DELETE','route' => ['results.destroy', $d->id],'style'=>'display:inline']) !!}
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
