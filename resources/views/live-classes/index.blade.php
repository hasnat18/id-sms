@extends('layouts.app')

@section('title', 'Live Classes')

@section('content')

    <div class="row page-titles">
        <div class="col-md-5 align-self-center">
            <h4 class="text-themecolor">All Live Classes</h4>
        </div>
        <div class="col-md-7 align-self-center text-right">
            <div class="d-flex justify-content-end align-items-center">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                    <li class="breadcrumb-item active">All Live Classes</li>
                </ol>
                @can('live-class-create')
                    <a href="{{ route('live-classes.create') }}" class="btn btn-info d-none d-lg-block m-l-15"><i class="fa fa-plus-circle"></i> Create New</a>
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

                    <h5 class="card-title">Live Classes list</h5>
                    <div class="table-responsive">
                        <table id="myTable" class="table table-striped">
                            <thead>
                            <tr>
                                <th>No</th>
                                <th>Class</th>
                                <th>Added By</th>
                                <th>Link</th>
                                <th>Status</th>
                                <th>Created At</th>
                                <th width="280px">Action</th>
                            </tr>
                            </thead>
                            <tbody>
                                @foreach ($data as $key => $d)
                                    <tr>
                                        <td>{{ $d->id }}</td>
                                        <td>{{ $d->__class->name }}</td>
                                        <td>{{ $d->user->name }}</td>
                                        <td><a href="{{ $d->meeting_link }}" target="_blank">{{ $d->meeting_link }}</a></td>
                                        <td>
                                            @if($d->status === 1)
                                                <label class="label label-primary">Active</label>
                                            @else
                                                <label class="label label-danger">Not Active</label>
                                            @endif
                                        </td>
                                        <td>{{ $d->created_at->format('M d, Y') }}</td>
                                        <td>
                                            @can('live-class-edit')
                                                <a class="btn btn-primary" href="{{ route('live-classes.edit',$d->id) }}">Edit</a>
                                            @endcan
                                            @can('live-class-delete')
                                                {!! Form::open(['method' => 'DELETE','route' => ['live-classes.destroy', $d->id],'style'=>'display:inline']) !!}
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



