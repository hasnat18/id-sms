@extends('layouts.app')

@section('title', 'Time Table Edit')

@section('content')
    <div class="row page-titles">
        <div class="col-md-5 align-self-center">
            <h4 class="text-themecolor">Time Table Edit</h4>
        </div>
        <div class="col-md-7 align-self-center text-right">
            <div class="d-flex justify-content-end align-items-center">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                    <li class="breadcrumb-item">Time Table</li>
                    <li class="breadcrumb-item active">Edit Time Table</li>
                </ol>
                <a href="{{ route('time-tables.index') }}" class="btn btn-info d-none d-lg-block m-l-15"><i class="fa fa-plus-circle"></i> Back</a>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-body">
                    @if ($message = Session::get('success'))
                        <div class="alert alert-success">
                            <p>{{ $message }}</p>
                        </div>
                    @endif

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

                    <h5 class="card-title">Edit Time Table</h5>


                    {!! Form::model($data,array('route' => ['time-tables.update',$data->id],'method'=>'POST',
                        'class' => 'form-material m-t-40 create', 'id' => 'submitted')) !!}

                    <div class="form-group">
                        <div class="row">
                            <label class="col-sm-12">Class Name</label>
                            <div class="col-sm-12 validate">
                                <select required name="__class_id" class="form-control" id="class_id">
                                    <option value="">Select Option</option>
                                    @foreach($classes as $cl)
                                        <option value="{{ $cl->id }}" {{ $data->__class_id == $cl->id ? 'selected' : '' }}>{{ $cl->name.' - '.$cl->section->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="row">
                            <label class="col-sm-12">Subject Name</label>
                            <div class="col-sm-12 validate">
                                <select required name="subject_id" class="form-control" id="subject_id">
                                    <option value="" >Select Option</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="row">
                            <div class="col-sm-6">
                                <label class="col-sm-12">Start Time</label>
                                <div class="col-sm-12 validate">
                                    <select required name="start_time" class="form-control" id="subject_id">
                                        @foreach($timeslots->timeslotarray() as $timeslot)
                                            <option value="{{$timeslot}}">{{$timeslot}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <label class="col-sm-12">End Time</label>
                                <div class="col-sm-12 validate">
                                    <select required name="end_time" class="form-control" id="subject_id">
                                        @foreach($timeslots->timeslotarray() as $timeslot)
                                            <option value="{{$timeslot}}">{{$timeslot}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="row">
                            <label class="col-sm-12">Day</label>
                            <div class="col-sm-12 validate">
                                <select required name="day" class="form-control" id="subject_id">
                                    <option value="Monday">Monday</option>
                                    <option value="Tuesday">Tuesday</option>
                                    <option value="Wednesday">Wednesday</option>
                                    <option value="Thursday">Thursday</option>
                                    <option value="Friday">Friday</option>
                                    <option value="Saturday">Saturday</option>
                                    <option value="Sunday">Sunday</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-info waves-effect waves-light m-r-10">Submit</button>
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
@endsection

@section('javascript')
    <script>
        $('#class_id').change( () => {
            var id = $('#class_id').val()
            $('#subject_id').html('')
            $.ajax({
                url: site_url+"/getSubjectsByClass/"+id,
                type: 'GET',
                dataType: 'json', // added data type
                success: function(res) {
                    $.each(res, (i, v) => {
                        $('#subject_id').append('<option value="'+v.id+'">'+v.name+'</option>')
                    })
                }
            });
        })
    </script>
@endsection
