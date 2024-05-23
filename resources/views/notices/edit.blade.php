@extends('layouts.app')

@section('title', 'Edit Notice')

@section('content')
    <div class="row page-titles">
        <div class="col-md-5 align-self-center">
            <h4 class="text-themecolor">Edit Notice</h4>
        </div>
        <div class="col-md-7 align-self-center text-right">
            <div class="d-flex justify-content-end align-items-center">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                    <li class="breadcrumb-item active">Notices</li>
                    <li class="breadcrumb-item active">Edit Notice</li>
                </ol>
                <a href="{{ route('notices.index') }}" class="btn btn-info d-none d-lg-block m-l-15"><i class="fa fa-plus-circle"></i> Back</a>
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

                    <h5 class="card-title">Edit Notice</h5>
                    {!! Form::model($data, array('route' => ['notices.update', $data->id],'method'=>'PATCH', 'class' => 'form-material m-t-40 create')) !!}
                    <div class="form-group">
                        <div class="row">
                            <label class="col-sm-12">Title</label>
                            <div class="col-sm-12 validate">
                                {!! Form::text('title', null, array('placeholder' => 'Title','class' => 'form-control', 'required')) !!}
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <label class="col-sm-12">Notice</label>
                            <div class="col-sm-12 validate">
                                {!! Form::textarea('notice', null, array('placeholder' => 'Notice','class' => 'form-control', 'required')) !!}
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-6">
                                <label class="col-sm-12">Start Date</label>
                                <div class="col-sm-12 validate">
                                    {!! Form::date('start_date', null, array('placeholder' => 'Notice','class' => 'form-control')) !!}
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label class="col-sm-12">End Date</label>
                                <div class="col-sm-12 validate">
                                    {!! Form::date('end_date', null, array('placeholder' => 'Notice','class' => 'form-control')) !!}
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="row">
                            <label class="col-sm-12">Status</label>
                            <div class="col-sm-12 validate">
                                <select name="status" class="form-control">
                                    <option value="">Select Option</option>
                                    <option value="1" {{ $data->status === 1 ? 'selected' : '' }}>Active</option>
                                    <option value="0" {{ $data->status === 0 ? 'selected' : '' }}>Not Active</option>
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
