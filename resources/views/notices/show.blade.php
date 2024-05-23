@extends('layouts.app')

@section('title', 'Show Notice')

@section('content')
    <div class="row page-titles">
        <div class="col-md-5 align-self-center">
            <h4 class="text-themecolor">Show Notices</h4>
        </div>
        <div class="col-md-7 align-self-center text-right">
            <div class="d-flex justify-content-end align-items-center">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                    <li class="breadcrumb-item active">Notices</li>
                    <li class="breadcrumb-item active">Show Notices</li>
                </ol>
                <a href="{{ route('notices.index')}}" class="btn btn-info d-none d-lg-block m-l-15"><i class="fa fa-plus-circle"></i> Back</a>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-body">
                    <h1><b>Notice Detail</b></h1>
{{--                    @dd($note);--}}
                    <h5 class="card-title"><b> From : {{ $note->user->name }}</b></h5>
                    <h5 class="card-title"><b>{{ \Carbon\Carbon::parse($note->created_at)->format('D-M-Y') }}</b></h5><br>
                    <div class="row">
                        <div class="col-lg-12">
                            <h3><b>Notice Title</b></h3>
                            <p class="card-title"><b>{{$note->title}}}</b></p>
                            <h3><b>Notice</b></h3>
                            <p class="card-title"><b>{{$note->notice}}}</b></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection








