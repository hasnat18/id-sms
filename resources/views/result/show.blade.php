@extends('layouts.app')

@section('title', 'Result Details')

@section('content')

    <div class="row page-titles">
        <div class="col-md-5 align-self-center">
            <h4 class="text-themecolor">Result Details</h4>
        </div>
        <div class="col-md-7 align-self-center text-right">
            <div class="d-flex justify-content-end align-items-center">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                    <li class="breadcrumb-item active">Result Details</li>
                </ol>
                <a href="{{ route('results.index') }}" class="btn btn-info d-none d-lg-block m-l-15"><i
                        class="fa fa-plus-circle"></i> Back</a>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">{{ $data->admission->student->name }}</h5>
                    <div class="row">
                        <div class="col-lg-8">
                            <p class="font-medium card-title">{{ $data->__class->name . ' - ' . $data->__class->section->name }}
                            </p>
                            <p class="card-title">Gender: {{ $data->admission->gender }}</p>
                            <p class="card-title">Date of birth: {{ $data->admission->dob }}</p>
                            <p class="card-title">Address: {{ $data->admission->address }}</p>
                            <p class="card-title">Phone: {{ $data->admission->phone }}</p>
                            <p class="card-title">Email: {{ $data->admission->email }}</p>
                            <h2><b>Result Details:</b></h2>
                            <div class="row">
                                <div class="col-lg-4">
                                    <h5 class="card-title">Exam Type: {{ $data->exam_type }}</h5>
                                </div>
                                <div class="col-lg-4">
                                    <h5 class="card-title">Total Marks: {{ $data->total_marks }}</h5>
                                </div>
                                <div class="col-lg-4">
                                    <h5 class="card-title">Obt. Marks: {{ $data->obtained_marks }}</h5>
                                </div>

                                <div class="col-lg-4">
                                    <h5 class="card-title">Percentage: {{ $data->percentage }}</h5>
                                </div>

                                <div class="col-lg-4">
                                    <h5 class="card-title">Grade: {{ $data->grade }}</h5>
                                </div>

                                <div class="col-lg-4">
                                    <h5 class="card-title">Status: {{ $data->status }}</h5>
                                </div>
                            </div>

                            @foreach ($rds as $r)
                                <div class="row p-4 text-center font-medium mt-2"
                                    style="background-color: #e7f1ff; color: #000000">
                                    <div class="col-lg-4">{{ $r->subject_name }}</div>
                                    <div class="col-lg-4">{{ $r->subject_marks }}</div>
                                    <div class="col-lg-4">{{ $r->obtained_marks }}</div>
                                </div>
                            @endforeach

                        </div>
                        <div class="col-lg-4">
                            <img src="{{ asset('uploads/students/' . $data->admission->student_pic) }}" alt=""
                                class="shadow-lg" height="150px">
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>

@endsection
