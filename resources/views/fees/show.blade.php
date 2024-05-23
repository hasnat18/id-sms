@extends('layouts.app')

@section('title', 'Show Fee')

@section('content')
    <div class="row page-titles">
        <div class="col-md-5 align-self-center">
            <h4 class="text-themecolor">Show Fee</h4>
        </div>
        <div class="col-md-7 align-self-center text-right">
            <div class="d-flex justify-content-end align-items-center">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                    <li class="breadcrumb-item active">Fees</li>
                    <li class="breadcrumb-item active">Show Fee</li>
                </ol>
                <a href="{{ route('fees.index') }}" class="btn btn-info d-none d-lg-block m-l-15"><i
                        class="fa fa-plus-circle"></i> Back</a>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">{{ $f->students->name }}</h5>
                    <small
                        class="font-medium card-title">{{ $f->students->_class->name . ' - ' . $f->students->_class->section->name }}</small>
                    <div class="row">
                        <div class="col-lg-8 mt-3"><br><br>
                            <h3 class="card-title"><b>Fee Details:</b></h3>
                            <div class="row">
                                <div class="col-lg-4">
                                    @foreach ($fds as $data2)
                                        <h6 class="card-title">Fee Type : <span
                                                class="text-uppercase">{{ $data2->fee_type }}</span></h6>
                                        <h6 class="card-title">Fee Amount: {{ $data2->fee_amount }}</h6><br>
                                    @endforeach()
                                    <h6 class="card-title">Total : <span class="text-uppercase">{{ $f->total }}</span>
                                    </h6><br>
                                </div>
                                <div class="col-lg-4">
                                    <h6 class="card-title">Month of :
                                        {{ \Carbon\Carbon::parse($f->month_of)->format('M-Y') }}</h6><br>
                                    <h6 class="card-title">Due Date : {{ $f->due_date }}</h6><br>
                                    <h6 class="card-title">Paid Date : {{ $f->paid_at }}</h6><br>
                                    {{--                                    @if ($f->status == 'paid') --}}
                                    {{--                                        <h6>Payment Type: <span class="text-uppercase">{{ $f->payment_type }}</span></h6><br> --}}
                                    {{--                                        <h6>Operator / Bank: {{ $f->operator }}</h6><br> --}}
                                    {{--                                        <h6>Transaction ID: {{ $f->transaction_id }}</h6><br> --}}
                                    {{--                                        <h6>Paid Amount: {{ $f->paid_amount }}</h6><br> --}}
                                    {{--                                        <h6>Balance Amount: {{ $f->balance_amount }}</h6><br> --}}
                                    {{--                                    @endif --}}
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div>
                                @if ($f->students->admission->student_pic !== null)
                                    <img src="{{ asset('uploads/students/' . $f->students->admission->student_pic) }}"
                                        alt="" style="height: 150px">
                                @endif
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection
