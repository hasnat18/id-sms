@extends('layouts.app')

@section('title', 'Registration Details')

@section('content')
    <div class="row page-titles">
        <div class="col-md-5 align-self-center">
            <h4 class="text-themecolor">Registration Details</h4>
        </div>
        <div class="col-md-7 align-self-center text-right">
            <div class="d-flex justify-content-end align-items-center">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                    <li class="breadcrumb-item active">Registration Details</li>
                </ol>
                <a href="{{ route('registrations.students') }}" class="btn btn-info d-none d-lg-block m-l-15"><i
                        class="fa fa-plus-circle"></i> Back</a>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-body">

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

                    @if ($message = Session::get('success'))
                        <div class="alert alert-success">
                            <p>{{ $message }}</p>
                        </div>
                    @endif

                    <div class="card-header">
                        <h5 class="card-title">Confirm Admission</h5>
                        <div class="card-toolbar">
                            @can('reg-status-change')
                                {!! Form::open([
                                    'method' => 'DELETE',
                                    'route' => ['registrations.cancel', $data->id],
                                    'style' => 'display:inline',
                                ]) !!}
                                {!! Form::submit('Cancel', ['class' => 'btn btn-danger', 'style' => 'margin-top:-40px']) !!}
                                {!! Form::close() !!}
                            @endcan
                        </div>
                    </div>

                    {!! Form::model($data, [
                        'route' => 'admission.store',
                        'method' => 'POST',
                        'class' => 'form-material m-t-40 create',
                        'enctype' => 'multipart/form-data',
                    ]) !!}
                    <input type="hidden" name="reg_id" value="{{ $data->id }}">
                    <h3>Personal Information</h3>

                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-6">
                                <label class="col-sm-12">Upload an image</label>
                                <div class="col-sm-12 validate">
                                    <input type="file" id="id_proof" name="id_proof" class="form-control"
                                        accept="image/*" onchange="loadImage(event)">
                                    <script>
                                        var loadImage = function(event) {

                                            var input = document.getElementById('id_proof');
                                            var file = input.files[0];
                                            if (file.size > 2097152) {
                                                alert("Cannot upload Files greater than 2MB")
                                                input.value = '';
                                            } else {
                                                var output = document.getElementById('image_uploaded');
                                                output.src = URL.createObjectURL(event.target.files[0]);
                                                output.onload = function() {
                                                    URL.revokeObjectURL(output.src) // free memory
                                                }
                                            }
                                        };
                                    </script>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="text-center">
                                    <img id="image_uploaded" src="{{ asset('placeholder.png') }}" alt=""
                                        style="margin-bottom: 15px; height: 200px;">
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-4">
                                <label class="col-sm-12">Student Name</label>
                                <div class="col-sm-12 validate">
                                    <input type="text" name="student_name" required placeholder="Student name"
                                        class="form-control" value="{{ $data->student_name }}">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <label class="col-sm-12">Gender</label>
                                <div class="d-flex">
                                    <div class="col-sm-12 validate">
                                        <select name="gender" class="form-control" required>
                                            <option value="male" {{ $data->gender == 'male' ? 'selected' : '' }}>Male
                                            </option>
                                            <option value="female" {{ $data->gender == 'female' ? 'selected' : '' }}>Female
                                            </option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <label class="col-sm-12">Date of birth</label>
                                <div class="col-sm-12 validate">
                                    <input type="date" name="dob" required value="{{ $data->dob }}"
                                        class="form-control">
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-4">
                                <label class="col-sm-12">Religion</label>
                                <div class="col-sm-12 validate">
                                    <input type="text" name="religion" required placeholder="Religion"
                                        value="{{ $data->religion }}" class="form-control">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <label class="col-sm-12">Cast</label>
                                <div class="col-sm-12 validate">
                                    <input type="text" name="cast" required placeholder="Cast"
                                        value="{{ $data->cast }}" class="form-control">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <label class="col-sm-12">Blood Group</label>
                                <div class="col-sm-12 validate">
                                    <input type="text" name="blood_group" placeholder="Blood Group"
                                        value="{{ $data->blood_group }}" class="form-control">
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-3">
                                <label class="col-sm-12">Address</label>
                                <div class="col-sm-12 validate">
                                    <input type="text" required placeholder="Address" name="address"
                                        value="{{ $data->address }}" class="form-control">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <label class="col-sm-12">State / Province</label>
                                <div class="col-sm-12 validate">
                                    <input type="text" required placeholder="State / Province" name="state"
                                        value="{{ $data->state }}" class="form-control">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <label class="col-sm-12">City</label>
                                <div class="col-sm-12 validate">
                                    <input type="text" required placeholder="City" name="city"
                                        value="{{ $data->city }}" class="form-control">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <label class="col-sm-12">Country</label>
                                <div class="col-sm-12 validate">
                                    <input type="text" required placeholder="Country" name="country"
                                        value="{{ $data->country }}" class="form-control">
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-4">
                                <label class="col-sm-12">Phone</label>
                                <div class="col-sm-12 validate">
                                    <input type="text" required placeholder="Phone" name="phone"
                                        value="{{ $data->phone }}" class="form-control">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <label class="col-sm-12">Email</label>
                                <div class="col-sm-12 validate">
                                    <input type="email" required placeholder="Email" name="email"
                                        value="{{ $data->email }}" class="form-control">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <label class="col-sm-12">Extra Note</label>
                                <div class="col-sm-12 validate">
                                    <input type="text" placeholder="Extra Note" name="extra_note"
                                        value="{{ $data->extra_note }}" class="form-control">
                                </div>
                            </div>
                        </div>
                    </div>

                    <hr>

                    <h3>Admission Information</h3>

                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-3">
                                <label class="col-sm-12">Requested Class</label>
                                <div class="col-sm-12 validate">
                                    <input type="text" readonly placeholder="class_name" name="phone"
                                        value="{{ $data->class_name }}" class="form-control">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <label class="col-sm-12">Selected Class</label>
                                <div class="col-sm-12 validate">
                                    <select name="selected_class" required class="form-control">
                                        <option value="">Select Class</option>
                                        @foreach (\App\Models\_Class::latest()->get() as $c)
                                            <option value="{{ $c->id }}">{{ $c->name . ' ' . $c->section->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <label class="col-sm-12">GR NO</label>
                                <div class="col-sm-12 validate">
                                    <input type="text" required placeholder="GR NO" name="gr_no"
                                        class="form-control">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <label class="col-sm-12">Roll No</label>
                                <div class="col-sm-12 validate">
                                    <input type="text" required placeholder="Roll No" name="roll_no"
                                        class="form-control">
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-6">
                                <label class="col-sm-12">Admission Fees</label>
                                <div class="col-sm-12 validate">
                                    <input type="text" required placeholder="Admission Fees" name="admission_fees"
                                        value="0" class="form-control">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label class="col-sm-12">Tuition Fees</label>
                                <div class="col-sm-12 validate">
                                    <input type="text" required placeholder="Admission Fees" name="tuition_fees"
                                        value="0" class="form-control">
                                </div>
                            </div>

                        </div>
                    </div>

                    <hr>
                    <h3>Parents Information</h3>

                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-4">
                                <label class="col-sm-12">Father Name</label>
                                <div class="col-sm-12 validate">
                                    <input type="text" required placeholder="Father Name" name="father_name"
                                        value="{{ $data->father_name }}" class="form-control">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <label class="col-sm-12">Father Phone</label>
                                <div class="col-sm-12 validate">
                                    <input type="text" placeholder="Father Phone" name="father_phone"
                                        value="{{ $data->father_phone }}" class="form-control">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <label class="col-sm-12">Father Occupation</label>
                                <div class="col-sm-12 validate">
                                    <input type="text" placeholder="Father Occupation" name="father_occ"
                                        value="{{ $data->father_occ }}" class="form-control">
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-4">
                                <label class="col-sm-12">Mother Name</label>
                                <div class="col-sm-12 validate">
                                    <input type="text" required placeholder="Mother Name" name="mother_name"
                                        value="{{ $data->mother_name }}" class="form-control">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <label class="col-sm-12">Mother Phone</label>
                                <div class="col-sm-12 validate">
                                    <input type="text" required placeholder="Mother Phone" name="mother_phone"
                                        value="{{ $data->mother_phone }}" class="form-control">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <label class="col-sm-12">Mother Occupation</label>
                                <div class="col-sm-12 validate">
                                    <input type="text" required placeholder="Mother Occupation" name="mother_occ"
                                        value="{{ $data->mother_occ }}" class="form-control">
                                </div>
                            </div>
                        </div>
                    </div>

                    <hr>
                    <h3>Transport Information</h3>

                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="row d-flex">
                                    <label class="col-sm-12">Want Transportation?</label>
                                    <input type="radio" name="is_trans" value="0" class="ml-4 mr-4"
                                        checked><span>No</span>
                                    <input type="radio" name="is_trans" value="1"
                                        class="ml-4 mr-4"><span>Yes</span>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <label class="col-sm-12">Transportation</label>
                                <div class="col-sm-12 validate">
                                    <select name="transportation" class="form-control">
                                        <option value="0">Select Option</option>
                                        @foreach (\App\Models\Transport::latest()->get() as $t)
                                            <option value="{{ $t->id }}">
                                                {{ $t->vehicle_number . '  ' . $t->vehicle_model }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <label class="col-sm-12">Transportation Fees</label>
                                <div class="col-sm-12 validate">
                                    <input type="text" placeholder="Transportation Fees" name="transportation_fees"
                                        value="0" class="form-control">
                                </div>
                            </div>
                        </div>
                    </div>

                    <hr>
                    <div class="form-group">
                        <div class="row d-flex">
                            <div class="alert alert-cyan">
                                <p>Student default password would be <b>student123 </b>. Which he/she can change after
                                    logging in.</p>
                            </div>
                            <label class="col-sm-12">Make Student Login</label>
                            <input type="radio" name="is_login" value="0" class="ml-4 mr-4"
                                checked><span>No</span>
                            <input type="radio" name="is_login" value="1" class="ml-4 mr-4"><span>Yes</span>
                        </div>
                    </div>

                    @if ($data->status == 'pending')
                        @can('admission-confirm')
                            <button type="submit" class="btn btn-info waves-effect waves-light m-r-10">Submit</button>
                        @endcan
                    @endif
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>

@endsection
