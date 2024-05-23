@extends('layouts.app')

@section('title', 'Assign Subjects')

@section('content')

    <div class="row page-titles">
        <div class="col-md-5 align-self-center">
            <h4 class="text-themecolor">Assign Subjects</h4>
        </div>
        <div class="col-md-7 align-self-center text-right">
            <div class="d-flex justify-content-end align-items-center">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                    <li class="breadcrumb-item active">Assign Subjects</li>
                </ol>
                <a href="{{ route('teachers.index') }}" class="btn btn-info d-none d-lg-block m-l-15"><i class="fa fa-plus-circle"></i> Back</a>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-body">

                    @if (Session::get('error'))
                        <div class="alert alert-danger">
                            <strong>Whoops!</strong> There were some problems with your input.<br><br>
                            <ul>
                                <p>{{ Session::get('error') }}</p>
                            </ul>
                        </div>
                    @endif

                    <h5 class="card-title">Assign Subjects</h5>

                        @if( count($staff->subjects) > 0 )
                            <p>
                                Assigend Subjects:
                                @foreach($staff->subjects as $subs)
                                    <label class="label label-primary">{{ $subs->name." - ".$subs->_class->name." - ".$subs->_class->section->name }}</label>
                                @endforeach
                            </p>
                        @endif
                    <p></p>
                    {!! Form::open(array('route' => 'teachers.assigend.subjects','method'=>'POST', 'class' => 'form-material m-t-40 create')) !!}
                        <input type="hidden" name="staff_id" value="{{ $staff_id }}">
                            <div class="form-group">
                                <div class="row">
                                    <label class="col-sm-12">Select Subjects</label>
                                    <div class="col-sm-12 validate">
                                        <div class="row">
                                            @foreach($subjects as $value)
                                            <div class="col-md-3">
                                                <label>
                                                    <input type="checkbox" class="name" name="subjects[]" value="{{ $value->id }}">
                                                    {{ $value->name." - ".$value->_class->name." - ".$value->_class->section->name }}</label>
                                            </div>
                                        @endforeach
                                        
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <button type="submit" class="btn btn-primary">Save</button>
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>

@endsection
