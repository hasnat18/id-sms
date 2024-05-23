@extends('layouts.app')

@section('title', 'Promoted Students')

@section('content')
    <div class="row page-titles">
        <div class="col-md-5 align-self-center">
            <h4 class="text-themecolor">Promoted Students</h4>
        </div>
        <div class="col-md-7 align-self-center text-right">
            <div class="d-flex justify-content-end align-items-center">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                    <li class="breadcrumb-item">Promoted Students</li>
                    <li class="breadcrumb-item active">Promoted Student Details</li>
                </ol>
                <a href="{{ route('promotes.index') }}" class="btn btn-info d-none d-lg-block m-l-15"><i
                        class="fa fa-plus-circle"></i> Back</a>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">{{ $data->name }}</h5>
                    <div class="row">
                        <div class="col-6">
                            <h4>Class Name: {{ $data->class_name . ' - ' . $data->section_name }}</h4>
                            <p>Gender: {{ $data->gender }}</p>
                            <p>Promoted Or Demoted: {{ $data->promoted_or_demoted }}</p>
                            <p>Status: {{ $data->status }}</p>
                            <p>Created At: {{ $data->created_at->format('M d, Y') }}</p>

                            <h3>Previous Results</h3>
                            @foreach ($results as $r)
                                <a href="{{ route('results.show', $r->id) }}"
                                    target="_blank">{{ route('results.show', $r->id) }}</a>
                            @endforeach
                        </div>
                        <div class="col-6 justify-content-center">
                            @if ($data->id_proof !== null)
                                <img src="{{ asset('uploads/students/' . $data->id_proof) }}" height="150px"
                                    class="h-50 shadow-lg">
                            @endif
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>

@endsection
