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
                    <h5 class="card-title">Update Promoted Student</h5>
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

                        <div class="col-12 mt-4">
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
                            <h3>Change Status</h3>
                            {!! Form::open([
                                'route' => ['promotes.update', $data->id],
                                'method' => 'PATCH',
                                'class' => 'form-material m-t-40 create',
                                'id' => 'submitted',
                            ]) !!}
                            <div class="row">
                                <div class="col-6">
                                    <select name="class_id" required class="form-control mb-4">
                                        <option value="">Select Option</option>
                                        @foreach ($classes as $cl)
                                            <option value="{{ $cl->id }}">{{ $cl->name . ' - ' . $cl->section->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-6">
                                    <select name="status" required class="form-control mb-4">
                                        <option value="">Select Option</option>
                                        <option value="pending" {{ $data->status === 'pending' ? 'selected' : '' }}>Pending
                                        </option>
                                        <option value="approved" {{ $data->status === 'approved' ? 'selected' : '' }}>
                                            Approved</option>
                                    </select>
                                </div>
                            </div>
                            <button type="submit" class="btn btn-info waves-effect waves-light m-r-10">Submit</button>
                            {!! Form::close() !!}
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>

@endsection
