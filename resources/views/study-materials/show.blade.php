@extends('layouts.app') @section('title', 'Show Study Material')
@section('content')
    <div class="row page-titles">
        <div class="col-md-5 align-self-center">
            <h4 class="text-themecolor">Show Study Material</h4>
        </div>
        <div class="col-md-7 align-self-center text-right">
            <div class="d-flex justify-content-end align-items-center">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                    <li class="breadcrumb-item active">Study Material</li>
                    <li class="breadcrumb-item active">Show Study Material</li>
                </ol> <a href="{{ route('study-materials.index') }}" class="btn btn-info d-none d-lg-block m-l-15"><i
                        class="fa fa-plus-circle"></i> Back</a>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-body"> {{-- @dd($sm->upload); --}}
                    <div class="row">
                        <div class="col-lg-8 mt-3">
                            <h3><b>Study Material Details</b></h3>
                            <br>
                            <br>
                            <h5 class="card-title">Uploaded By : {{ $sm->user->name }}</h5>
                            <h5 class="card-title"><b>For Class : {{ $c->name }}</b></h5>
                            <br>
                            <h5 class="card-title">Description</h5>
                            <p>{{ $sm->text }}</p>
                            <br>
                            <div class="row"> </div>
                        </div>
                        <div class="col-lg-4">
                            <div>
                                @if ($sm->upload !== null)
                                    <img src="{{ asset('uploads/study/' . $sm->upload) }}" alt=""
                                        style="height: 150px">
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
</div> @endsection
