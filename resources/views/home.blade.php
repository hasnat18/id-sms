@extends('layouts.app')

@section('title', 'Home')

@section('content')

    <div class="row page-titles">
        <div class="col-md-5 align-self-center">
            <h4 class="text-themecolor">Home</h4>
        </div>
        <div class="col-md-7 align-self-center text-right">
            <div class="d-flex justify-content-end align-items-center">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                    <li class="breadcrumb-item active">Dashboard</li>
                </ol>
            </div>
        </div>
    </div>

    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="row">
            @if (auth()->user()->is_teacher)
                @include('teacher-home')
            @endif

            @if (auth()->user()->is_student)
                @include('student-home')
            @endif

            @if (auth()->user()->is_admin)
                @include('admin-home')
            @endif
        </div>
    </div>

@endsection
