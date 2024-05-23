@extends('layouts.app') @section('title', 'Show Study Material')
@section('content')
    <div class="row page-titles">
        <div class="col-md-5 align-self-center">
            <h4 class="text-themecolor">Staff Leave Detail</h4> </div>
        <div class="col-md-7 align-self-center text-right">
            <div class="d-flex justify-content-end align-items-center">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="javascript:void(0)">All Staff Leave</a></li>
                    <li class="breadcrumb-item active">Staff Leave Details</li>
                </ol> <a href="{{ route('staff-leave.index') }}" class="btn btn-info d-none d-lg-block m-l-15"><i class="fa fa-plus-circle"></i> Back</a> </div>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-8 mt-3">
                            <h3 class="card-title"><b>Staff Leave Detail</b></h3>
{{--                            @dd($data)--}}
                            <br>
                            <br>
                            <h5 class="card-title">Staff Name : {{ $data->staff->name }}</h5>
                            <br>
                            <h5 class="card-title">From : {{$data->start_date}}</h5>
                            <br>
                            <h5 class="card-title">Till : {{$data->end_date}}</h5>
                            <br>
                            <h5 class="card-title">Reason : {{$data->reason}}</h5>
                            <br>
                            <h5 class="card-title">Status : {{$data->status}}</h5>
                            <br>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
