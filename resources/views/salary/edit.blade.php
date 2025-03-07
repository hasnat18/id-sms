@extends('layouts.app')

@section('title', 'Edit Salary')

@section('content')
    <div class="row page-titles">
        <div class="col-md-5 align-self-center">
            <h4 class="text-themecolor">Edit Salary</h4>
        </div>
        <div class="col-md-7 align-self-center text-right">
            <div class="d-flex justify-content-end align-items-center">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                    <li class="breadcrumb-item active">Staff Salary</li>
                    <li class="breadcrumb-item active">Edit Staff Salary</li>
                </ol>
                <a href="{{ route('salaries.index') }}" class="btn btn-info d-none d-lg-block m-l-15"><i class="fa fa-plus-circle"></i> Back</a>
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

                    <h5 class="card-title">Edit Salary</h5>
                    {!! Form::model($data, array('route' => ['salaries.update', $data->id],'method'=>'PATCH', 'class' => 'form-material m-t-40 create')) !!}
                    <div class="form-group">
                        <div class="row">
                            <label class="col-sm-12">Staff Name</label>
                            <div class="col-sm-12 validate">
                                {!! Form::select('staff_id', \App\Models\Staff::pluck('name', 'id'),null, array('class' => 'form-control', 'required','disabled')) !!}
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-6">
                                <label class="col-sm-12">Create Salary</label>
                                <div class="col-sm-12 validate">
                                    {!! Form::text('salary', null, array('placeholder' => 'Salary','class' => 'form-control', 'required')) !!}
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label class="col-sm-12">Deduction Days</label>
                                <div class="col-sm-12 validate">
                                    {!! Form::number('deduction_days', null, array('placeholder' => 'Salary','class' => 'form-control')) !!}
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-6">
                                <label class="col-sm-12">Deduction</label>
                                <div class="col-sm-12 validate">
{{--                                    @dd($data)--}}
                                    {!! Form::text('deduction', null, array('placeholder' => 'Deduction','class' => 'form-control','value' => '{{$data->staff_id}}')) !!}
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label class="col-sm-12">Month Of</label>
                                <div class="col-sm-12 validate">
                                    {!! Form::text('month_of', null, array('class' => 'form-control', 'required','disabled')) !!}
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <label class="col-sm-12">Note</label>
                            <div class="col-sm-12 validate">
                                {!! Form::textarea('note', null, array('placeholder' => 'Note','class' => 'form-control')) !!}
                            </div>
                        </div>
                    </div>
                        <div class="form-group">
                            <div class="row">
                                <label class="col-sm-12">Status</label>
                                <div class="col-sm-12 validate">
                                    <select name="status" required class="form-control">
                                        <option value="">Select Option</option>
                                        <option value="pending" {{ $data->status === 'pending' ? 'selected' : '' }}>Pending</option>
                                        <option value="approved" {{ $data->status === 'approved' ? 'selected' : '' }}>Approved</option>
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
