@extends('layouts.app')

@section('title', 'Admission Update')

@section('content')
    <div class="row page-titles">
        <div class="col-md-5 align-self-center">
            <h4 class="text-themecolor">Admission Details</h4>
        </div>
        <div class="col-md-7 align-self-center text-right">
            <div class="d-flex justify-content-end align-items-center">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                    <li class="breadcrumb-item">Admission</li>
                    <li class="breadcrumb-item active">Update Admission</li>
                </ol>
                <a href="{{ route('admission.index') }}" class="btn btn-info d-none d-lg-block m-l-15"><i
                        class="fa fa-plus-circle"></i> Back</a>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="alert alert-cyan">
                <p>Student default password would be <b>student123 </b>. Which he/she can change after logging in.</p>
            </div>
            @if (count($errors) > 0)
                <div class="alert alert-danger">
                    <strong>Whoops!</strong> Something went wrong with your inputs.<br><br>
                </div>
            @endif

            @if ($message = Session::get('success'))
                <div class="alert alert-success">
                    <p>{{ $message }}</p>
                </div>
            @endif
        </div>
    </div>

    {!! Form::model($data, [
        'route' => ['admission.update', $data->id],
        'method' => 'PATCH',
        'class' => 'row form-material create',
        'enctype' => 'multipart/form-data',
    ]) !!}

    {{-- Personal Details --}}
    <div class="col-sm-6" style="max-width: 100%;">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Personal Information</h5>
                <div class="mt-2 mb-2">
                    <label for="student_name" class="form-label">Student Name <span
                            class="m-l-5 text-danger">*</span></label>
                    <input type="text" class="form-control @error('student_name') is-invalid @enderror" id="student_name"
                        name="student_name" value="{{ old('student_name', $data->student_name) }}" required>
                    @error('student_name')
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
                        <img id="image_uploaded" src="{{ asset('uploads/students/' . $data->student_pic) }}" alt=""
                            style="margin-bottom: 15px; height: 100px;">
                    </div>
                </div>

                <div class="mt-2 mb-2">
                    <label for="gender" class="form-label">Gender <span class="m-l-5 text-danger">*</span></label>
                    <select name="gender" class="form-control @error('gender') is-invalid @enderror" required>
                        <option value="male" {{ $data->gender == 'male' ? 'selected' : '' }}>Male</option>
                        <option value="female" {{ $data->gender == 'female' ? 'selected' : '' }}>Female</option>
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
                    <label for="religion" class="form-label">Religion <span class="m-l-5 text-danger">*</span></label>
                    <input type="text" class="form-control @error('religion') is-invalid @enderror" id="religion"
                        name="religion" value="{{ old('religion', $data->religion) }}" required>
                    @error('religion')
                        <span class="text-danger" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <div class="mt-2 mb-2">
                    <label for="cast" class="form-label">Cast <span class="m-l-5 text-danger">*</span></label>
                    <input type="text" class="form-control @error('cast') is-invalid @enderror" id="religion"
                        name="cast" value="{{ old('cast', $data->cast) }}" required>
                    @error('cast')
                        <span class="text-danger" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <div class="mt-2 mb-2">
                    <label for="blood_group" class="form-label">Blood Group</label>
                    <input type="text" class="form-control @error('blood_group') is-invalid @enderror" id="blood_group"
                        name="blood_group" value="{{ old('blood_group', $data->blood_group) }}">
                    @error('blood_group')
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
                    <label for="state" class="form-label">State / Province <span
                            class="m-l-5 text-danger">*</span></label>
                    <input type="text" class="form-control @error('state') is-invalid @enderror" id="state"
                        name="state" value="{{ old('state', $data->state) }}" required>
                    @error('state')
                        <span class="text-danger" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <div class="mt-2 mb-2">
                    <label for="city" class="form-label">City <span class="m-l-5 text-danger">*</span></label>
                    <input type="text" class="form-control @error('city') is-invalid @enderror" id="city"
                        name="city" value="{{ old('city', $data->city) }}" required>
                    @error('city')
                        <span class="text-danger" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <div class="mt-2 mb-2">
                    <label for="country" class="form-label">Country <span class="m-l-5 text-danger">*</span></label>
                    <input type="text" class="form-control @error('country') is-invalid @enderror" id="country"
                        name="country" value="{{ old('country', $data->country) }}" required>
                    @error('country')
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

                <div class="mt-2 mb-2">
                    <label for="extra_note" class="form-label">Extra Note</label>
                    <input type="extra_note" class="form-control @error('address') is-invalid @enderror" id="extra_note"
                        name="extra_note" value="{{ old('extra_note', $data->extra_note) }}">
                    @error('extra_note')
                        <span class="text-danger" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
            </div>
        </div>
    </div>

    <div class="col-sm-6" style="max-width: 100%;">
        {{-- Parents Information --}}
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Parents Information</h5>
                <div class="mt-2 mb-2">
                    <label for="father_name" class="form-label">Father Name <span
                            class="m-l-5 text-danger">*</span></label>
                    <input type="text" class="form-control @error('father_name') is-invalid @enderror"
                        id="father_name" name="father_name" value="{{ old('father_name', $data->father_name) }}"
                        required>
                    @error('father_name')
                        <span class="text-danger" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <div class="mt-2 mb-2">
                    <label for="father_phone" class="form-label">Father Phone</label>
                    <input type="text" class="form-control @error('father_phone') is-invalid @enderror"
                        id="father_phone" name="father_phone" value="{{ old('father_phone', $data->father_phone) }}">
                    @error('father_phone')
                        <span class="text-danger" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <div class="mt-2 mb-2">
                    <label for="father_occ" class="form-label">Father Occupation</label>
                    <input type="text" class="form-control @error('father_occ') is-invalid @enderror" id="father_occ"
                        name="father_occ" value="{{ old('father_occ', $data->father_occ) }}">
                    @error('father_occ')
                        <span class="text-danger" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <div class="mt-2 mb-2">
                    <label for="mother_name" class="form-label">Mother Name <span
                            class="m-l-5 text-danger">*</span></label>
                    <input type="text" class="form-control @error('mother_name') is-invalid @enderror"
                        id="mother_name" name="mother_name" value="{{ old('mother_name', $data->mother_name) }}"
                        required>
                    @error('mother_name')
                        <span class="text-danger" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <div class="mt-2 mb-2">
                    <label for="mother_phone" class="form-label">Mother Phone</label>
                    <input type="text" class="form-control @error('mother_phone') is-invalid @enderror"
                        id="mother_phone" name="mother_phone" value="{{ old('mother_phone', $data->mother_phone) }}">
                    @error('mother_phone')
                        <span class="text-danger" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <div class="mt-2 mb-2">
                    <label for="mother_occ" class="form-label">Mother Occupation</label>
                    <input type="text" class="form-control @error('mother_occ') is-invalid @enderror" id="mother_occ"
                        name="mother_occ" value="{{ old('mother_occ', $data->mother_occ) }}">
                    @error('mother_occ')
                        <span class="text-danger" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
            </div>
        </div>
        {{-- Admission Details --}}
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Admission Details</h5>

                <div class="mt-2 mb-2">
                    <label for="selected_class" class="form-label">Select Class <span
                            class="m-l-5 text-danger">*</span></label>
                    <select name="selected_class" class="form-control @error('selected_class') is-invalid @enderror"
                        required>
                        <option value="">Select Class</option>
                        @foreach (\App\Models\_Class::latest()->get() as $c)
                            <option value="{{ $c->id }}" {{ $c->id == $data->__class_id ? 'selected' : '' }}>
                                {{ $c->name . ' ' . $c->section->name }}</option>
                        @endforeach
                    </select>
                    @error('selected_class')
                        <span class="text-danger" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div class="mt-2 mb-2">
                    <label for="gr_no" class="form-label">GR No <span class="m-l-5 text-danger">*</span></label>
                    <input type="text" class="form-control @error('gr_no') is-invalid @enderror" id="gr_no"
                        name="gr_no" value="{{ old('gr_no', $data->gr_no) }}" required readonly>
                    @error('gr_no')
                        <span class="text-danger" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div class="mt-2 mb-2">
                    <label for="roll_no" class="form-label">Roll No <span class="m-l-5 text-danger">*</span></label>
                    <input type="text" class="form-control @error('roll_no') is-invalid @enderror" id="roll_no"
                        name="roll_no" value="{{ old('roll_no', $data->student->roll_no) }}" required readonly>
                    @error('roll_no')
                        <span class="text-danger" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
            </div>
        </div>
        {{-- Fee Details --}}
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Fees Details</h5>
                <div class="mt-2 mb-2">
                    <label for="admission_fees" class="form-label">Admission Fees <span
                            class="m-l-5 text-danger">*</span></label>
                    <input type="text" class="form-control @error('admission_fees') is-invalid @enderror"
                        id="admission_fees" name="admission_fees" value="{{ old('admission_fees', $ad_fee) }}" required>
                    @error('admission_fees')
                        <span class="text-danger" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <div class="mt-2 mb-2">
                    <label for="tuition_fees" class="form-label">Tuition Fees <span
                            class="m-l-5 text-danger">*</span></label>
                    <input type="text" class="form-control @error('tuition_fees') is-invalid @enderror"
                        id="tuition_fees" name="tuition_fees" value="{{ old('tuition_fees', $tt_fee) }}" required>
                    @error('tuition_fees')
                        <span class="text-danger" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
            </div>
        </div>
        {{-- Transportation Details --}}
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Transportation Details</h5>
                <div class="mt-2 mb-2">
                    <label for="is_trans" class="form-label">Want Transportation? <span
                            class="m-l-5 text-danger">*</span></label>
                    <input type="radio" name="is_trans" value="0" class="ml-4 mr-2"
                        {{ $data->is_trans == 0 ? 'checked' : '' }}><span>No</span>
                    <input type="radio" name="is_trans" value="1" class="ml-4 mr-2"
                        {{ $data->is_trans == 1 ? 'checked' : '' }}><span>Yes</span>
                </div>
                <div class="mt-2 mb-2">
                    <label for="transport_id" class="form-label">Transports </label>
                    <select name="transport_id" class="form-control">
                        <option value="">Select Option</option>
                        @foreach (\App\Models\Transport::latest()->get() as $t)
                            <option value="{{ $t->id }}" {{ $t->id == $data->transport_id ? 'selected' : '' }}>
                                {{ $t->vehicle_number . '  ' . $t->vehicle_model }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="mt-2 mb-2">
                    <label for="transportation_fees" class="form-label">Transportation Fees </label>
                    <input type="text" class="form-control @error('transportation_fees') is-invalid @enderror"
                        id="transportation_fees" name="transportation_fees"
                        value="{{ old('transportation_fees', $tp_fee) }}">
                    @error('transportation_fees')
                        <span class="text-danger" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
            </div>
        </div>
        @if ($data->student_auth_id == null)
            {{-- Login Details --}}
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Login Details</h5>
                    <div class="mt-2 mb-2">
                        <label for="is_login" class="form-label">Make Student Login <span
                                class="m-l-5 text-danger">*</span></label>
                        <input type="radio" name="is_login" value="0" class="ml-4 mr-2" checked><span>No</span>
                        <input type="radio" name="is_login" value="1" class="ml-4 mr-2"><span>Yes</span>
                    </div>
                </div>
            </div>
        @endif
        <div class="card">
            <div class="card-body">
                @can('admission-confirm')
                    <button type="submit" class="btn btn-info waves-effect waves-light m-r-10 btn-block">Submit</button>
                @endcan
            </div>
        </div>
    </div>

    {!! Form::close() !!}

@endsection
