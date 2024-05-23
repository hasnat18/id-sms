@extends('layouts.app')

@section('title', 'Fees')

@section('content')

    <div class="row page-titles">
        <div class="col-md-5 align-self-center">
            <h4 class="text-themecolor">All Fees</h4>
        </div>
        <div class="col-md-7 align-self-center text-right">
            <div class="d-flex justify-content-end align-items-center">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                    <li class="breadcrumb-item active">All Fees</li>
                </ol>
                @can('fee-create')
                    <a href="{{ route('fees.create') }}" class="btn btn-info d-none d-lg-block m-l-15"><i class="fa fa-plus-circle"></i> Create New</a>
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

                    <div class="d-flex justify-content-between">
                        <h5 class="card-title">Fees list</h5>
                        @if( auth()->user()->is_admin )
                            <a class="btn btn-primary" href="{{ route('fees.print.all') }}">Print All</a>
                            <a class="btn btn-outline-primary" href="javascript::void(0)" onclick="printSelected()">Print Selected</a>
                        @endif
                    </div>

                    <div class="table-responsive">
                        <table id="myTable" class="table table-striped">
                            <thead>
                            <tr>
                                <th></th>
                                <th>No</th>
                                <th>GR NO</th>
                                <th>Session</th>
                                <th>Student Name</th>
                                <th>Student Class</th>
                                <th>Month Of</th>
                                <th>Due Date</th>
                                <th>Arrears</th>
                                <th>Total</th>
                                <th>Status</th>
                                <th width="280px">Action</th>
                            </tr>
                            </thead>
                            <tbody>
                                @foreach ($data as $key => $d)
                                    <tr>
                                        <td>
                                            @if( !auth()->user()->is_student )
                                                <input type="checkbox" id="{{ 'chk_'.$d->id }}" value="{{ $d->id }}">
                                            @endif
                                        </td>
                                        <td>{{ $d->id }}</td>
                                        <td>{{ $d->students->admission->gr_no }}</td>
                                        <td>{{ \Carbon\Carbon::parse($d->_session->start_date)->format('Y')." - ".\Carbon\Carbon::parse($d->_session->end_date)->format('Y') }}</td>
                                        <td>{{ $d->students->name }}</td>
                                        <td>{{ $d->students->_class->name." - ".$d->students->_class->section->name }}</td>
                                        <td>{{ $d->month_of }}</td>
                                        <td>{{ \Carbon\Carbon::parse($d->due_date)->format('M d, Y') }}</td>
                                        <td>{{ $d->arrears }}</td>
                                        <td>{{ $d->total }}</td>
                                        <td>
                                            @if($d->status == 'pending')
                                                <label class="label label-warning">{{ $d->status }}</label>
                                            @elseif($d->status == 'paid')
                                                <label class="label label-success">{{ $d->status }}</label>
                                            @else
                                                <label class="label label-danger">{{ $d->status }}</label>
                                            @endif
                                        </td>
                                        <td>
                                            @if( !auth()->user()->is_student )
                                                <a class="btn btn-info" href="{{ route('fees.print', $d->id) }}" target="_blank">Print</a>
                                            @endif
                                                                                    <a class="btn btn-info" href="{{ route('fees.show',$d->id) }}">Show</a>
                                            @can('fee-edit')
                                                <a class="btn btn-primary" href="{{ route('fees.edit',$d->id) }}">Pay</a>
                                            @endcan
                                            @can('fee-delete')
                                                {!! Form::open(['method' => 'DELETE','route' => ['fees.destroy', $d->id],'style'=>'display:inline']) !!}
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


@section('javascript')

    <script>
        function printSelected() {
            var data = {!! $data !!}
            var arr = []
            $.each(data, (i, v) => {
                var chk = $('#chk_'+v.id).is(':checked')
                if (chk === true){
                    arr.push(v.id)
                }
            })
            if (arr.length > 0){
                var arrStr = JSON.stringify(arr);
                console.log(arrStr)
                window.location = 'fees/print/'+arrStr;
            }
            else{
                alert('No fees selected')
            }
        }
    </script>

@endsection


