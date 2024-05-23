@extends('layouts.app')

@section('title', '403')

@section('content')
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card">
                    <div class="d-flex align-items-center">
                        <div class="col-sm-12">
                            <div class="card-body text-center">
                                <h3 class="card-title" style="color:#004274">Forbidden</h3>
                                <h4>{{ $message }}</h4>
                                <p class="form-label mt-3">Sorry, you are not authorized to access this page.</p>
                                <p class="form-label mt-3">Please contact the administrator for further assistance.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
