@extends('layouts.app')

@section('title', 'Show Leave')

@section('content')
    <div class="row page-titles">
        <div class="col-md-5 align-self-center">
            <h4 class="text-themecolor">Show Leave</h4>
        </div>
        <div class="col-md-7 align-self-center text-right">
            <div class="d-flex justify-content-end align-items-center">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                    <li class="breadcrumb-item active">Leave</li>
                    <li class="breadcrumb-item active">Show Leave</li>
                </ol>
                <a href="{{ route('student-leaves.index')}}" class="btn btn-info d-none d-lg-block m-l-15"><i class="fa fa-plus-circle"></i> Back</a>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-body">
                    <h3><b>Student Details</b></h3>
                    <h5 class="card-title"><b>{{$sl->Student->name}}</b></h5>
{{--                    @dd($sl->student->_class->name." - ".$sl->student  ->_class->section->name);--}}
                    <h5 class="card-title"><b>Student Id :  {{ $sl->student_id }}</b></h5>
                    <h5 class="card-title"><b>Class Id :  {{ $sl->student->_class->name." - ".$sl->student  ->_class->section->name }}</b></h5><br>
                    <h3><b>Leave Details</b></h3><br>
                    <h5 class="card-title"><span><b> From  :  </b></span>{{ \Carbon\Carbon::parse($sl->created_at)->format('D-M-Y') }}</h5>
                    <h5 class="card-title"><b>To  :  </b>{{ \Carbon\Carbon::parse($sl->created_at)->format('D-M-Y') }}</h5>
                    <div class="row">
                        <div class="col-lg-12">
                            <h6 class="card-title"><b>Status : </b>
                                @if($sl->status === 'pending')
                                    <label class="label label-warning card-title"><b>pending</b></label>
                                @else
                                    <label class="label label-danger"><b>Approved</b></label>
                                @endif</h6>
                            <h3><b>Reason</b></h3>
                            <p><b></b>{{$sl->reason}}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

{{--@dd($sl);--}}






