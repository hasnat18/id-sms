@extends('layouts.app')

@section('title', 'Create Teacher')

@section('content')
    <div class="row page-titles">
        <div class="col-md-5 align-self-center">
            <h4 class="text-themecolor">Teacher Details</h4>
        </div>
        <div class="col-md-7 align-self-center text-right">
            <div class="d-flex justify-content-end align-items-center">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                    <li class="breadcrumb-item">Teachers</li>
                    <li class="breadcrumb-item active">Create Tearcher</li>
                </ol>
                <a href="{{ route('teachers.index') }}" class="btn btn-info d-none d-lg-block m-l-15"><i
                        class="fa fa-plus-circle"></i> Back</a>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="alert alert-warning">
                <p>Default teacher login password will be <b>teacher123</b> .</p>
            </div>
            @if (count($errors) > 0)
                <div class="alert alert-danger">
                    <strong>Whoops!</strong> There were some problems with your input.<br><br>
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            @if (Session::get('error'))
                <div class="alert alert-danger">
                    <strong>Whoops!</strong> There were some problems with your input.<br><br>
                    <ul>
                        <p>{{ Session::get('error') }}</p>
                    </ul>
                </div>
            @endif
        </div>
    </div>

    {!! Form::open([
        'route' => 'teachers.store',
        'method' => 'POST',
        'class' => 'row form-material create',
        'enctype' => 'multipart/form-data',
    ]) !!}
    {{-- Personal Information --}}
    <div class="col-sm-6" style="max-width: 100%;">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Personal Information</h5>
                <div class="mt-2 mb-2">
                    <label for="name" class="form-label">Name <span class="m-l-5 text-danger">*</span></label>
                    <input type="text" class="form-control @error('name') is-invalid @enderror" id="name"
                        name="name" value="{{ old('name') }}" required>
                    @error('name')
                        <span class="text-danger" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <div class="d-flex">
                    <div class="mt-2 mb-2 mr-2">
                        <input type="file" id="id_proof" name="id_proof" class="form-control" accept="image/*"
                            onchange="loadImage(event)">
                        <script>
                            var loadImage = function(event) {
                                var input = document.getElementById('id_proof');
                                var file = input.files[0];
                                if (file.size > 2097152) {
                                    alert("Cannot upload files greater than 2MB");
                                    input.value = '';
                                } else {
                                    var output = document.getElementById('image_uploaded');
                                    output.src = URL.createObjectURL(event.target.files[0]);
                                    output.onload = function() {
                                        URL.revokeObjectURL(output.src); // free memory
                                    }
                                }
                            };
                        </script>
                        @error('id_proof')
                            <span class="text-danger" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div class="p-3 text-center">
                        <img id="image_uploaded" src="{{ asset('placeholder.png') }}" alt=""
                            style="margin-bottom: 15px; height: 100px;">
                    </div>
                </div>
                <div class="mt-2 mb-2">
                    <label for="gender" class="form-label">Gender <span class="m-l-5 text-danger">*</span></label>
                    <select name="gender" class="form-control @error('gender') is-invalid @enderror" required>
                        <option value="male">Male</option>
                        <option value="female">Female</option>
                    </select>
                    @error('gender')
                        <span class="text-danger" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <div class="mt-2 mb-2">
                    <label for="dob" class="form-label">Date of birth <span class="m-l-5 text-danger">*</span></label>
                    <input type="date" class="form-control @error('dob') is-invalid @enderror" id="dob"
                        name="dob" value="{{ old('dob') }}" required>
                    @error('dob')
                        <span class="text-danger" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <div class="mt-2 mb-2">
                    <label for="address" class="form-label">Address <span class="m-l-5 text-danger">*</span></label>
                    <input type="text" class="form-control @error('address') is-invalid @enderror" id="address"
                        name="address" value="{{ old('address') }}" required>
                    @error('address')
                        <span class="text-danger" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <div class="mt-2 mb-2">
                    <label for="phone" class="form-label">Phone <span class="m-l-5 text-danger">*</span></label>
                    <input type="text" class="form-control @error('phone') is-invalid @enderror" id="phone"
                        name="phone" value="{{ old('phone') }}" required>
                    @error('phone')
                        <span class="text-danger" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <div class="mt-2 mb-2">
                    <label for="email" class="form-label">Email <span class="m-l-5 text-danger">*</span></label>
                    <input type="email" class="form-control @error('address') is-invalid @enderror" id="email"
                        name="email" value="{{ old('email') }}" required>
                    @error('email')
                        <span class="text-danger" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
            </div>
        </div>
    </div>

    <div class="col-sm-6" style="max-width: 100%;">
        {{-- Joining Information --}}
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Joining Information</h5>

                <div class="mt-2 mb-2">
                    <label for="joining_date" class="form-label">Joining date <span
                            class="m-l-5 text-danger">*</span></label>
                    <input type="date" class="form-control @error('joining_date') is-invalid @enderror"
                        id="joining_date" name="joining_date" value="{{ old('joining_date') }}" required>
                    @error('joining_date')
                        <span class="text-danger" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <div class="mt-2 mb-2">
                    <label for="salary" class="form-label">Salary <span class="m-l-5 text-danger">*</span></label>
                    <input type="text" class="form-control @error('salary') is-invalid @enderror" id="salary"
                        name="salary" value="{{ old('salary') }}" required>
                    @error('salary')
                        <span class="text-danger" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
            </div>
        </div>
        <div class="card">
            <div class="card-body">
                <button type="submit" class="btn btn-info waves-effect waves-light m-r-10 btn-block">Submit</button>
            </div>
        </div>
    </div>

    {!! Form::close() !!}
@endsection
