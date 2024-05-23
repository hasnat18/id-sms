@extends('layouts.app')

@section('title', 'Staff Edit')

@section('content')
    <div class="row page-titles">
        <div class="col-md-5 align-self-center">
            <h4 class="text-themecolor">Staff Details</h4>
        </div>
        <div class="col-md-7 align-self-center text-right">
            <div class="d-flex justify-content-end align-items-center">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                    <li class="breadcrumb-item">Staffs</li>
                    <li class="breadcrumb-item active">Edit Staff</li>
                </ol>
                <a href="{{ route('staffs.index') }}" class="btn btn-info d-none d-lg-block m-l-15"><i
                        class="fa fa-plus-circle"></i> Back</a>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="alert alert-warning">
                <p>Default staff login password will be <b>staff123</b> .</p>
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
    {!! Form::model($data, [
        'route' => ['staffs.update', $data->id],
        'method' => 'PATCH',
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
                        name="name" value="{{ old('name', $data->name) }}" required>
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
                    </div>
                    <div class="p-3 text-center">
                        <img id="image_uploaded"
                            src="{{ $data->id_proof !== null ? url('public/uploads/staffs/' . $data->id_proof) : url('public/placeholder.png') }}"
                            alt="" style="margin-bottom: 15px; height: 100px;">
                    </div>
                </div>
                <div class="mt-2 mb-2">
                    <label for="gender" class="form-label">Gender <span class="m-l-5 text-danger">*</span></label>
                    <select name="gender" class="form-control @error('gender') is-invalid @enderror" required>
                        <option value="male" {{ $data->gender == 'male' ? 'selected' : '' }}>Male
                        </option>
                        <option value="female" {{ $data->gender == 'female' ? 'selected' : '' }}>Female
                        </option>
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
                        name="dob" value="{{ old('dob', $data->dob) }}" required>
                    @error('dob')
                        <span class="text-danger" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <div class="mt-2 mb-2">
                    <label for="address" class="form-label">Address <span class="m-l-5 text-danger">*</span></label>
                    <input type="text" class="form-control @error('address') is-invalid @enderror" id="address"
                        name="address" value="{{ old('address', $data->address) }}" required>
                    @error('address')
                        <span class="text-danger" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <div class="mt-2 mb-2">
                    <label for="phone" class="form-label">Phone <span class="m-l-5 text-danger">*</span></label>
                    <input type="text" class="form-control @error('phone') is-invalid @enderror" id="phone"
                        name="phone" value="{{ old('phone', $data->phone) }}" required>
                    @error('phone')
                        <span class="text-danger" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <div class="mt-2 mb-2">
                    <label for="email" class="form-label">Email <span class="m-l-5 text-danger">*</span></label>
                    <input type="email" class="form-control @error('address') is-invalid @enderror" id="email"
                        name="email" value="{{ old('email', $data->email) }}" required>
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
                        id="joining_date" name="joining_date" value="{{ old('joining_date', $data->joining_date) }}"
                        required>
                    @error('joining_date')
                        <span class="text-danger" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <div class="mt-2 mb-2">
                    <label for="salary" class="form-label">Salary <span class="m-l-5 text-danger">*</span></label>
                    <input type="text" class="form-control @error('salary') is-invalid @enderror" id="salary"
                        name="salary" value="{{ old('salary', $data->salary) }}" required>
                    @error('salary')
                        <span class="text-danger" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <div class="mt-2 mb-2">
                    <label for="department" class="form-label">Department <span
                            class="m-l-5 text-danger">*</span></label>
                    <select name="department" class="form-control @error('department') is-invalid @enderror" required>
                        <option value="">Select Option</option>
                        @foreach ($deps as $d)
                            <option value="{{ $d->id }}"
                                @isset($data->users->department->id) 
                                {{ $d->id == $data->users->department->id ? 'selected' : '' }}
                            @endisset>
                                {{ $d->name }}</option>
                        @endforeach
                    </select>
                    @error('department')
                        <span class="text-danger" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <div class="mt-2 mb-2">
                    <label for="roles" class="form-label">Role <span class="m-l-5 text-danger">*</span></label>
                    <select name="roles" class="form-control @error('role') is-invalid @enderror" required>
                        <option value="">Select Option</option>
                        @foreach ($roles as $role)
                            <option value="{{ $role->id }}"
                                @isset($userRole->id) 
                                {{ $role->id == $userRole->id ? 'selected' : '' }}
                            @endisset>
                                {{ $role->name }}</option>
                        @endforeach
                    </select>
                    @error('roles')
                        <span class="text-danger" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
            </div>
        </div>

        {{-- Transportation Information --}}
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Transportation Information</h5>

                <div class="mt-2 mb-2">
                    <label for="is_bus_incharge" class="form-label">Is bus incharge</label>
                    <input type="radio" name="is_bus_incharge" value="0"
                        {{ $data->is_bus_incharge == 0 ? 'checked' : '' }}><span> No </span>
                    <input type="radio" name="is_bus_incharge" value="1"
                        {{ $data->is_bus_incharge == 1 ? 'checked' : '' }}><span> Yes </span>
                </div>
                <div class="mt-2 mb-2">
                    <label for="department" class="form-label">Transports </label>
                    <select name="transport_id" class="form-control">
                        <option value="">Select Option</option>
                        @foreach ($transports as $t)
                            <option value="{{ $t->id }}" {{ $t->id == $data->transport_id ? 'selected' : '' }}>
                                {{ $t->vehicle_number . '  ' . $t->vehicle_model }}</option>
                        @endforeach
                    </select>
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
