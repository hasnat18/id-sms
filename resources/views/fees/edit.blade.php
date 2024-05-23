@extends('layouts.app')

@section('title', 'Pay Fee')

@section('content')
    <div class="row page-titles">
        <div class="col-md-5 align-self-center">
            <h4 class="text-themecolor">Show Fee</h4>
        </div>
        <div class="col-md-7 align-self-center text-right">
            <div class="d-flex justify-content-end align-items-center">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                    <li class="breadcrumb-item active">Fees</li>
                    <li class="breadcrumb-item active">Pay Fee</li>
                </ol>
                <a href="{{ route('fees.index') }}" class="btn btn-info d-none d-lg-block m-l-15"><i
                        class="fa fa-plus-circle"></i> Back</a>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-body">
                    <h3>{{ \Carbon\Carbon::parse($data->_session->start_date)->format('Y') . ' - ' . \Carbon\Carbon::parse($data->_session->end_date)->format('Y') }}
                    </h3>
                    <div class="d-flex justify-content-between">
                        <div>
                            <h5 class="card-title">{{ $data->students->name }}</h5>
                            <small>{{ $data->students->_class->name . ' - ' . $data->students->_class->section->name }}</small>
                        </div>
                        <div class="text-right">
                            <h5 class="font-bold"> Challan Id: {{ $data->id }}</h5>
                            @if ($data->status == 'pending')
                                <label class="label label-warning">{{ $data->status }}</label>
                            @elseif($data->status == 'paid')
                                <label class="label label-success">{{ $data->status }}</label>
                            @else
                                <label class="label label-danger">{{ $data->status }}</label>
                            @endif
                            <div>
                                @if ($data->students->admission->student_pic !== null)
                                    <img src="{{ asset('uploads/students/' . $data->students->admission->student_pic) }}"
                                        alt="" style="height: 150px">
                                @endif
                            </div>
                        </div>
                    </div>

                    <div>
                        <table border="1" style="width: 100%;text-align: center;font-weight: bold;">
                            <thead>
                                <td>#</td>
                                <td>Fee Type</td>
                                <td>Fee Amount</td>
                            </thead>
                            <tbody style="font-weight: normal" id="tb">
                                @foreach ($data->feedetails as $key => $fd)
                                    <tr>
                                        <td>{{ $key + 1 }}</td>
                                        <td>{{ $fd->fee_type }}</td>
                                        <td>{{ $fd->fee_amount }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <h6 class="mt-5">Fee Total: <span class="text-uppercase">{{ $data->total }}</span></h6>
                        <h6>Arrears: {{ $data->arrears }}</h6>
                        <h6>Month of: {{ $data->month_of }}</h6>
                        <h6>Due Date: {{ $data->due_date }}</h6>
                        <h6>Paid Date: {{ $data->paid_at }}</h6>


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
                        {!! Form::model($data, [
                            'route' => ['fees.update', $data->id],
                            'method' => 'PATCH',
                            'class' => 'form-material m-t-40 create',
                        ]) !!}

                        {{--                            <div class="form-group"> --}}
                        {{--                                <div class="row"> --}}
                        {{--                                    <label class="col-sm-12">Payment Type</label> --}}
                        {{--                                    <div class="col-sm-12 validate"> --}}
                        {{--                                        <select name="payment_type" class="form-control" > --}}
                        {{--                                            <option value="">Select Option</option> --}}
                        {{--                                            <option value="Cash">Cash</option> --}}
                        {{--                                            <option value="Jazz Cash">Jazz Cash</option> --}}
                        {{--                                            <option value="Easy Paisa">Easy Paisa</option> --}}
                        {{--                                            <option value="Bank Deposit">Bank Deposit</option> --}}
                        {{--                                            <option value="Cheaque Deposit">Cheaque Deposit</option> --}}
                        {{--                                            <option value="Pay Order">Pay Order</option> --}}
                        {{--                                        </select> --}}
                        {{--                                    </div> --}}
                        {{--                                </div> --}}
                        {{--                            </div> --}}

                        {{--                            <div class="form-group"> --}}
                        {{--                                <div class="row"> --}}
                        {{--                                    <label class="col-sm-12">Operator / Bank</label> --}}
                        {{--                                    <div class="col-sm-12 validate"> --}}
                        {{--                                        <input type="text" value="{{ $data->operator }}" name="operator" class="form-control" > --}}
                        {{--                                    </div> --}}
                        {{--                                </div> --}}
                        {{--                            </div> --}}
                        {{--                            <div class="form-group"> --}}
                        {{--                                <div class="row"> --}}
                        {{--                                    <label class="col-sm-12">Transaction ID</label> --}}
                        {{--                                    <div class="col-sm-12 validate"> --}}
                        {{--                                        <input type="text" value="{{ $data->transaction_id }}" name="transaction_id" class="form-control"> --}}
                        {{--                                    </div> --}}
                        {{--                                </div> --}}
                        {{--                            </div> --}}
                        {{--                            <div class="form-group"> --}}
                        {{--                                <div class="row"> --}}
                        {{--                                    <label class="col-sm-12">Paid Amount</label> --}}
                        {{--                                    <div class="col-sm-12 validate"> --}}
                        {{--                                        <input type="text" value="{{ $data->paid_amount > 0 ? $data->paid_amount : $data->fee_amount }}" name="paid_amount" class="form-control" required> --}}
                        {{--                                    </div> --}}
                        {{--                                </div> --}}
                        {{--                            </div> --}}
                        {{--                            <div class="form-group"> --}}
                        {{--                                <div class="row"> --}}
                        {{--                                    <label class="col-sm-12">Discount Amount</label> --}}
                        {{--                                    <div class="col-sm-12 validate"> --}}
                        {{--                                        <input type="text" value="{{ $data->fee_discount }}" name="fee_discount" class="form-control"> --}}
                        {{--                                    </div> --}}
                        {{--                                </div> --}}
                        {{--                            </div> --}}
                        <button class="btn btn-primary" type="submit">Submit</button>
                        {!! Form::close() !!}
                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection
