@extends('layouts.app')

@section('title', 'Teachers')

@section('content')

    <div class="row page-titles">
        <div class="col-md-5 align-self-center">
            <h4 class="text-themecolor">All Teachers</h4>
        </div>
        <div class="col-md-7 align-self-center text-right">
            <div class="d-flex justify-content-end align-items-center">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                    <li class="breadcrumb-item active">All Teachers</li>
                </ol>
                @can('staff-create')
                <a href="{{ route('teachers.create') }}" class="btn btn-info d-none d-lg-block m-l-15"><i
                        class="fa fa-plus-circle"></i> Create New</a>
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

                    <h5 class="card-title">Teachers list</h5>
                    <div class="table-responsive">
                        <table id="myTable" class="table table-striped">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Name</th>
                                    <th>Gender</th>
                                    <th>Phone</th>
                                    <th>Email</th>
                                    <th width="280px">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($teachers as $key => $d)
                                    <tr>
                                        <td>{{ ucwords($d->id) }}</td>
                                        <td>{{ ucwords($d->name) }}</td>
                                        <td>{{ ucwords($d->gender) }}</td>
                                        <td>{{ ucwords($d->phone) }}</td>
                                        <td>{{ $d->email }}</td>
                                        <td>
                                            <a class="btn btn-info" href="{{ route('teachers.show', $d->id) }}">Show</a>
                                            @can('teacher-edit')
                                                <a class="btn btn-primary" href="{{ route('teachers.edit', $d->id) }}">Assign
                                                    Subjects</a>
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
