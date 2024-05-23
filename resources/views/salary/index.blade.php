@extends('layouts.app')

@section('title', 'Staffs Salary')

@section('content')
    <div class="row page-titles">
        <div class="col-md-5 align-self-center">
            <h4 class="text-themecolor">All Staffs salaries</h4>
        </div>
        <div class="col-md-7 align-self-center text-right">
            <div class="d-flex justify-content-end align-items-center">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                    <li class="breadcrumb-item active">View Staff Salary</li>
                </ol>
                @can('salary-create')
                    <a href="{{ route('salaries.create') }}" class="btn btn-info d-none d-lg-block m-l-15"><i class="fa fa-plus-circle"></i> Create New</a>
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

                    <h5 class="card-title">Staffs Salaries</h5>
                    {{--                    <div class="alert alert-warning">--}}
                    {{--                        <p>If admission record is deleted everything that is attached to that admission will be deleted also.</p>--}}
                    {{--                    </div>--}}
                    <div class="table-responsive">
                        <table id="myTable" class="table table-striped">
                            <thead>
                            <tr>
                                <th>No</th>
                                <th>Name</th>
                                <th>Salary</th>
                                <th>Deduction</th>
                                <th>Deduction Days</th>
                                <th>Month_Of</th>
                                <th>Note </th>
                                <th>Status</th>
                                <th width="300px">Action</th>
                            </tr>
                            </thead>
                            <tbody>
{{--                            @dd($data);--}}
                            @foreach ($data as $key => $d)
                                <tr>
                                    <td>{{ $d->id }}</td>
                                    <td>{{ $d->staff->name }}</td>
                                    <td>{{ $d->salary }}</td>
                                    <td>{{ $d->deduction }}</td>
                                    <td>{{ $d->deduction_days }}</td>
                                    <td>{{ $d->month_of }}</td>
                                    <td>{{ substr($d->note, 0, 30) }}</td>
                                    <td>
                                        @if($d->status === 'pending')
                                            <label class="label label-danger">PENDING</label>
                                        @else
                                            <label class="label label-success">APPROVED</label>
                                        @endif
                                    </td>
                                    <td width="150px">
                                        <a class="btn btn-info mx-2" href="{{ route('salaries.show',$d->id) }}">Show</a>
                                    @can('salary-edit')
                                            <a class="btn btn-primary mx-2" href="{{ route('salaries.edit',$d->id) }}">Edit</a>
                                        @endcan
                                        @can('salary-delete')
                                            {!! Form::open(['method' => 'DELETE','route' => ['salaries.destroy', $d->id],'style'=>'display:inline']) !!}
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
