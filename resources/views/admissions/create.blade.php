@extends('layouts.app')

@section('title', 'Admission Create')

@section('content')

    <style>
        .parent-fields, .guardian-fields {
            display: none;
        }
    </style>

    <div class="row page-titles">
        <div class="col-md-5 align-self-center">
            <h4 class="text-themecolor">Admission Details</h4>
        </div>
        <div class="col-md-7 align-self-center text-right">
            <div class="d-flex justify-content-end align-items-center">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                    <li class="breadcrumb-item">Admission</li>
                    <li class="breadcrumb-item active">Craete Admission</li>
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
                {{Log::info($errors)}}
                <div class="alert alert-danger">
                    <strong>Whoops!</strong> Something went wrong with your inputs.<br><br>
                </div>
            @endif
        </div>
    </div>

    {!! Form::open([
        'route' => 'admission.store',
        'method' => 'POST',
        'class' => 'row form-material create',
        'enctype' => 'multipart/form-data',
    ]) !!}

    {{-- Personal Details --}}
    <div class="col-sm-6" style="max-width: 100%;">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Personal Information</h5>


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
                        <img id="image_uploaded" src="{{ asset('/placeholder.png') }}" alt=""
                            style="margin-bottom: 15px; height: 100px;">
                    </div>
                </div>

                <div class="mt-2 mb-2">
                    <label for="student_name" class="form-label">Student Name <span class="m-l-5 text-danger">*</span></label>
                    <input type="text" class="form-control @error('student_name') is-invalid @enderror" id="student_name" name="student_name" value="{{ old('student_name') }}" required>
                    @error('student_name')
                        <span class="text-danger" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div class="mt-2 mb-2">
                    <label for="student_email" class="form-label">Student Email</label>
                    <input type="email" class="form-control @error('student_email') is-invalid @enderror" id="student_email" name="student_email" value="{{ old('student_email') }}">
                    @error('student_email')
                        <span class="text-danger" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div class="mt-2 mb-2">
                    <label for="student_gender" class="form-label">Gender <span class="m-l-5 text-danger">*</span></label>
                    <select name="student_gender" class="form-control @error('student_gender') is-invalid @enderror" required>
                        <option value="male">Male</option>
                        <option value="female">Female</option>
                    </select>
                    @error('student_gender')
                        <span class="text-danger" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div class="mt-2 mb-2">
                    <label for="student_phone" class="form-label">Student Phone <span class="m-l-5 text-danger">*</span></label>
                    <input type="text" class="form-control @error('student_phone') is-invalid @enderror" id="student_phone" name="student_phone" value="{{ old('student_phone') }}">
                    @error('student_phone')
                        <span class="text-danger" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div class="mt-2 mb-2">
                    <label for="student_dob" class="form-label">Student Date of Birth <span class="m-l-5 text-danger">*</span></label>
                    <input type="date" class="form-control @error('student_dob') is-invalid @enderror" id="student_dob" name="student_dob" value="{{ old('student_dob') }}" required>
                    @error('student_dob')
                        <span class="text-danger" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div class="mt-2 mb-2">
                    <label for="student_address" class="form-label">Student Address</label><span class="m-l-5 text-danger">*</span></label>
                    <input type="text" class="form-control @error('student_address') is-invalid @enderror" id="student_address" name="student_address" value="{{ old('student_address') }}" required>
                    @error('student_address')
                        <span class="text-danger" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div class="mt-2 mb-2">
                    <label for="student_nationality" class="form-label">Student Nationality</label><span class="m-l-5 text-danger">*</span></label>
                    <input type="text" class="form-control @error('student_nationality') is-invalid @enderror" id="student_nationality" name="student_nationality" value="{{ old('student_nationality') }}" required>
                    @error('student_nationality')
                        <span class="text-danger" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div class="mt-2 mb-2">
                    <label for="student_religion" class="form-label">Student Religion</label><span class="m-l-5 text-danger">*</span></label>
                    <input type="text" class="form-control @error('student_religion') is-invalid @enderror" id="student_religion" name="student_religion" value="{{ old('student_religion') }}" required>
                    @error('student_religion')
                        <span class="text-danger" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div class="mt-2 mb-2">
                    <label for="student_last_school_attend" class="form-label">Last School Attended</label>
                    <input type="text" class="form-control @error('student_last_school_attend') is-invalid @enderror" id="student_last_school_attend" name="student_last_school_attend" value="{{ old('student_last_school_attend') }}">
                    @error('student_last_school_attend')
                        <span class="text-danger" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div class="mt-2 mb-2">
                    <label for="student_admission_date" class="form-label">Admission Date</label>
                    <input type="date" class="form-control @error('student_admission_date') is-invalid @enderror" id="student_admission_date" name="student_admission_date" value="{{ old('student_admission_date') }}">
                    @error('student_admission_date')
                        <span class="text-danger" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div class="mt-2 mb-2">
                    <label for="student_state" class="form-label">State</label><span class="m-l-5 text-danger">*</span></label>
                    <input type="text" class="form-control @error('student_state') is-invalid @enderror" id="student_state" name="student_state" value="{{ old('student_state') }}" required>
                    @error('student_state')
                        <span class="text-danger" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div class="mt-2 mb-2">
                    <label for="student_city" class="form-label">City</label><span class="m-l-5 text-danger">*</span></label>
                    <input type="text" class="form-control @error('student_city') is-invalid @enderror" id="student_city" name="student_city" value="{{ old('student_city') }}" required>
                    @error('student_city')
                        <span class="text-danger" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div class="mt-2 mb-2">
                    <label for="student_country" class="form-label">Country</label><span class="m-l-5 text-danger">*</span></label>
                    <input type="text" class="form-control @error('student_country') is-invalid @enderror" id="student_country" name="student_country" value="{{ old('student_country') }}" required>
                    @error('student_country')
                        <span class="text-danger" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>


                <div class="mt-2 mb-2">
                    <label for="extra_note" class="form-label">Extra Note</label>
                    <input type="extra_note" class="form-control @error('address') is-invalid @enderror" id="extra_note"
                        name="extra_note" value="{{ old('extra_note') }}">
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
                <h5 class="card-title">Select Information Type</h5>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="info_type" id="parentsRadio" value="parents" onclick="toggleFields()" checked>
                    <label class="form-check-label" for="parentsRadio">
                        Parents
                    </label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="info_type" id="guardianRadio" value="guardian" onclick="toggleFields()">
                    <label class="form-check-label" for="guardianRadio">
                        Guardian
                    </label>
                </div>
            </div>
        </div>

        <div class="card parent-fields mt-4">
            <div class="card-body">
                <h5 class="card-title">Parents Information</h5>
                <!-- Father details -->
                <div class="mt-2 mb-2">
                    <label for="father_name" class="form-label">Father Name</label>
                    <input type="text" class="form-control @error('father_name') is-invalid @enderror" id="father_name" name="father_name" value="{{ old('father_name') }}" >
                    @error('father_name')
                        <span class="text-danger" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <div class="mt-2 mb-2">
                    <label for="father_occupation" class="form-label">Father Occupation</label>
                    <input type="text" class="form-control @error('father_occupation') is-invalid @enderror" id="father_occupation" name="father_occupation" value="{{ old('father_occupation') }}">
                    @error('father_occupation')
                        <span class="text-danger" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <div class="mt-2 mb-2">
                    <label for="father_office_address" class="form-label">Father Office Address</label>
                    <input type="text" class="form-control @error('father_office_address') is-invalid @enderror" id="father_office_address" name="father_office_address" value="{{ old('father_office_address') }}">
                    @error('father_office_address')
                        <span class="text-danger" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <div class="mt-2 mb-2">
                    <label for="father_contact" class="form-label">Father Contact</label>
                    <input type="text" class="form-control @error('father_contact') is-invalid @enderror" id="father_contact" name="father_contact" value="{{ old('father_contact') }}">
                    @error('father_contact')
                        <span class="text-danger" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <!-- Mother details -->
                <div class="mt-2 mb-2">
                    <label for="mother_name" class="form-label">Mother Name</label>
                    <input type="text" class="form-control @error('mother_name') is-invalid @enderror" id="mother_name" name="mother_name" value="{{ old('mother_name') }}" >
                    @error('mother_name')
                        <span class="text-danger" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <div class="mt-2 mb-2">
                    <label for="mother_contact" class="form-label">Mother Contact</label>
                    <input type="text" class="form-control @error('mother_contact') is-invalid @enderror" id="mother_contact" name="mother_contact" value="{{ old('mother_contact') }}">
                    @error('mother_contact')
                        <span class="text-danger" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
            </div>
        </div>

        <div class="card guardian-fields mt-4">
            <div class="card-body">
                <h5 class="card-title">Guardian Information</h5>
                <!-- Guardian details -->
                <div class="mt-2 mb-2">
                    <label for="guardian_name" class="form-label">Guardian Name</label>
                    <input type="text" class="form-control @error('guardian_name') is-invalid @enderror" id="guardian_name" name="guardian_name" value="{{ old('guardian_name') }}" >
                    @error('guardian_name')
                        <span class="text-danger" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <div class="mt-2 mb-2">
                    <label for="guardian_occupation" class="form-label">Guardian Occupation</label>
                    <input type="text" class="form-control @error('guardian_occupation') is-invalid @enderror" id="guardian_occupation" name="guardian_occupation" value="{{ old('guardian_occupation') }}">
                    @error('guardian_occupation')
                        <span class="text-danger" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <div class="mt-2 mb-2">
                    <label for="guardian_office_address" class="form-label">Guardian Office Address</label>
                    <input type="text" class="form-control @error('guardian_office_address') is-invalid @enderror" id="guardian_office_address" name="guardian_office_address" value="{{ old('guardian_office_address') }}">
                    @error('guardian_office_address')
                        <span class="text-danger" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <div class="mt-2 mb-2">
                    <label for="guardian_contact" class="form-label">Guardian Contact</label>
                    <input type="text" class="form-control @error('guardian_contact') is-invalid @enderror" id="guardian_contact" name="guardian_contact" value="{{ old('guardian_contact') }}">
                    @error('guardian_contact')
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
                            <option value="{{ $c->id }}">{{ $c->name . ' ' . $c->section->name }}</option>
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
                        name="gr_no" value="{{ old('gr_no') }}" required>
                    @error('gr_no')
                        <span class="text-danger" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div class="mt-2 mb-2">
                    <label for="roll_no" class="form-label">Roll No <span class="m-l-5 text-danger">*</span></label>
                    <input type="text" class="form-control @error('roll_no') is-invalid @enderror" id="roll_no"
                        name="roll_no" value="{{ old('roll_no') }}" required>
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
                    <input type="number" class="form-control @error('admission_fees') is-invalid @enderror"
                        id="admission_fees" name="admission_fees" value="{{ old('admission_fees') }}" required>
                    @error('admission_fees')
                        <span class="text-danger" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <div class="mt-2 mb-2">
                    <label for="tuition_fees" class="form-label">Tuition Fees <span
                            class="m-l-5 text-danger">*</span></label>
                    <input type="number" class="form-control @error('tuition_fees') is-invalid @enderror"
                        id="tuition_fees" name="tuition_fees" value="{{ old('tuition_fees') }}" required>
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
                    <label for="is_trans" class="form-label">Want Transportation? <span class="m-l-5 text-danger">*</span></label>
                    <input type="radio" name="is_trans" value="0" class="ml-4 mr-2" checked><span>No</span>
                    <input type="radio" name="is_trans" value="1" class="ml-4 mr-2"><span>Yes</span>
                </div>
                <div class="mt-2 mb-2">
                    <label for="transport_id" class="form-label">Transports </label>
                    <select name="transport_id" class="form-control">
                        <option value="">Select Option</option>
                        @foreach (\App\Models\Transport::latest()->get() as $t)
                            <option value="{{ $t->id }}">{{ $t->vehicle_number . '  ' . $t->vehicle_model }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="mt-2 mb-2">
                    <label for="transportation_fees" class="form-label">Transportation Fees </label>
                    <input type="text" class="form-control @error('transportation_fees') is-invalid @enderror"
                        id="transportation_fees" name="transportation_fees" value="{{ old('transportation_fees') }}">
                    @error('transportation_fees')
                        <span class="text-danger" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
            </div>
        </div>
        {{-- Login Details --}}
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Login Details</h5>
                <div class="mt-2 mb-2">
                    <label for="is_login" class="form-label">Make Student Login <span class="m-l-5 text-danger">*</span></label>
                    <input type="radio" name="is_login" value="0" class="ml-4 mr-2" checked><span>No</span>
                    <input type="radio" name="is_login" value="1" class="ml-4 mr-2"><span>Yes</span>
                </div>
            </div>
        </div>
        <div class="card">
            <div class="card-body">
                @can('admission-confirm')
                <button type="submit" class="btn btn-info waves-effect waves-light m-r-10 btn-block">Submit</button>
                @endcan
            </div>
        </div>
    </div>
    {!! Form::close() !!}


    <script>
        function toggleFields() {
            var parentsFields = document.querySelector('.parent-fields');
            var guardianFields = document.querySelector('.guardian-fields');

            if (document.getElementById('parentsRadio').checked) {
                parentsFields.style.display = 'block';
                guardianFields.style.display = 'none';
            } else {
                parentsFields.style.display = 'none';
                guardianFields.style.display = 'block';
            }
        }

        // Initialize the fields based on the default selected radio button
        window.onload = toggleFields;
    </script>

@endsection
