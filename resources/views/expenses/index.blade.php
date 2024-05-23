@extends('layouts.app')

@section('title', 'Expenses')

@section('content')

    <div class="row page-titles">
        <div class="col-md-5 align-self-center">
            <h4 class="text-themecolor">All Expenses</h4>
        </div>
        <div class="col-md-7 align-self-center text-right">
            <div class="d-flex justify-content-end align-items-center">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                    <li class="breadcrumb-item active">All Expenses</li>
                </ol>
                @can('expense-create')
                    <a href="{{ route('expenses.create') }}" class="btn btn-info d-none d-lg-block m-l-15"><i class="fa fa-plus-circle"></i> Create New</a>
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

                    <h5 class="card-title">Expenses list</h5>
                    <div class="table-responsive">
                        <table id="myTable" class="table table-striped">
                            <thead>
                            <tr>
                                <th>No</th>
                                <th>Expense</th>
                                <th>Note</th>
                                <th>Added By</th>
                                <th>Create At</th>
                                <th width="280px">Action</th>
                            </tr>
                            </thead>
                            <tbody>
                                @foreach ($data as $key => $d)
                                    <tr>
                                        <td>{{ $d->id }}</td>
                                        <td>{{ $d->expense }}</td>
                                        <td>{{ $d->note }}</td>
                                        <td>{{ $d->user->name }}</td>
                                        <td>{{ $d->date }}</td>
                                        <td>
                                            @can('expense-edit')
                                                <a class="btn btn-primary" href="{{ route('expenses.edit',$d->id) }}">Edit</a>
                                            @endcan
                                            @can('expense-delete')
                                                {!! Form::open(['method' => 'DELETE','route' => ['expenses.destroy', $d->id],'style'=>'display:inline']) !!}
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



