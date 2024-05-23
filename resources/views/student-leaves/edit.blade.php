@extends('layouts.app')

@section('title', 'Edit Student Leave')

@section('content')
    <div class="row page-titles">
        <div class="col-md-5 align-self-center">
            <h4 class="text-themecolor">Edit Student Leave</h4>
        </div>
        <div class="col-md-7 align-self-center text-right">
            <div class="d-flex justify-content-end align-items-center">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                    <li class="breadcrumb-item active">Student Leaves</li>
                    <li class="breadcrumb-item active">Edit Student Leave</li>
                </ol>
                <a href="{{ route('student-leaves.index') }}" class="btn btn-info d-none d-lg-block m-l-15"><i class="fa fa-plus-circle"></i> Back</a>
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

                    <h5 class="card-title">Update Student Leave</h5>
                    {!! Form::model($data, array('route' => ['student-leaves.update', $data->id],'method'=>'PATCH', 'class' => 'form-material m-t-40 create')) !!}
                    <div class="form-group">
                        <div class="row">
                            <label class="col-sm-12">Student Name</label>
                            <div class="col-sm-12 validate">
                                <input type="hidden" name="student_id" value="{{ $data->student_id }}">
                                {!! Form::select('student_id', \App\Models\Student::pluck('name', 'id'),null, array('class' => 'form-control', 'required', 'disabled')) !!}
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="row">
                            <label class="col-sm-12">Start Date</label>
                            <div class="col-sm-12 validate">
                                {!! Form::date('start_date', null, array('class' => 'form-control', 'required')) !!}
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="row">
                            <label class="col-sm-12">End Date</label>
                            <div class="col-sm-12 validate">
                                {!! Form::date('end_date', null, array('class' => 'form-control', 'required')) !!}
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="row">
                            <label class="col-sm-12">Reason</label>
                            <div class="col-sm-12 validate">
                                {!! Form::textarea('reason', null, array('class' => 'form-control', 'required')) !!}
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="row">
                                @if(auth()->user()->is_student)
                                    <input type="hidden" name="status" value="{{ $data->status }}">
                                @else
                                <label class="col-sm-12">Status</label>
                                    <div class="col-sm-12 validate">
                                        <select name="status" class="form-control">
                                            <option value="">Select Option</option>
                                            <option value="approved" {{ $data->status === 'approved' ? 'selected' : '' }}>Approved</option>
                                            <option value="pending" {{ $data->status === 'pending' ? 'selected' : '' }}>Pending</option>
                                        </select>
                                    </div>
                                @endif
                        </div>
                    </div>
                    <button type="submit" class="btn btn-info waves-effect waves-light m-r-10">Submit</button>
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
@endsection
