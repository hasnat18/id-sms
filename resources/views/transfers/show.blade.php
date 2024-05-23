@extends('layouts.app')

@section('title', 'Show Transfer')

@section('content')
    <div class="row page-titles">
        <div class="col-md-5 align-self-center">
            <h4 class="text-themecolor">Show Transfer</h4>
        </div>
        <div class="col-md-7 align-self-center text-right">
            <div class="d-flex justify-content-end align-items-center">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                    <li class="breadcrumb-item active">Transfers</li>
                    <li class="breadcrumb-item active">Show Transfer</li>
                </ol>
                <a href="{{ route('transfers.index') }}" class="btn btn-info d-none d-lg-block m-l-15"><i
                        class="fa fa-plus-circle"></i> Back</a>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-body">

                    <h5 class="card-title">Details</h5>
                    <div class="row">
                        <div class="col-xs-12 col-sm-12 col-md-12">
                            <div class="form-group">
                                <strong>School Name:</strong>
                                {{ $data->school_name }}
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-12">
                            <div class="form-group">
                                <strong>Class Name:</strong>
                                {{ $data->class_name }}
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-12">
                            <div class="form-group">
                                <strong>Student Name:</strong>
                                {{ $data->admission->student_name }}
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-12">
                            <div class="form-group">
                                <strong>Student GR NO:</strong>
                                {{ $data->admission->gr_no }}
                            </div>
                        </div>
                        @if ($data->doc !== null)
                            <div class="col-xs-12 col-sm-12 col-md-12">
                                <div class="form-group">
                                    <strong>Attached Document:</strong>
                                    <img src="{{ asset('uploads/transfers/' . $data->doc) }}" alt=""
                                        style="height: 400px;">
                                </div>
                            </div>
                        @endif
                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection
