@extends('layouts.app')

@section('title', 'Students Details')

@section('content')
    <div class="row page-titles">
        <div class="col-md-5 align-self-center">
            <h4 class="text-themecolor">Students Details</h4>
        </div>
        <div class="col-md-7 align-self-center text-right">
            <div class="d-flex justify-content-end align-items-center">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                    <li class="breadcrumb-item active">All Students</li>
                </ol>
                <a href="{{ route('students.index') }}" class="btn btn-info d-none d-lg-block m-l-15"><i
                        class="fa fa-plus-circle"></i> Back</a>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-8">
                            <h5 class="card-title">Details of Student: <strong>{{ ucwords($data->name) }}</strong></h5><br>
                            <h5><b> Class : </b><strong>{{ ucwords($data->_class->name) }}</strong></h5>
                            <h5 class="my-3"><b> Section :
                                </b><strong>{{ ucwords($data->_class->section->name) }}</strong></b></h5>
                            <h5 class="my-3"><b> Roll Number : </b><strong>{{ ucwords($data->roll_no) }}</strong></h5>
                            <h5 class="my-3"><b> city : </b><strong>{{ ucwords($data->admission->city) }}</strong></h5>
                            <h5 class="my-3"><b> state : </b><strong>{{ ucwords($data->admission->state) }}</strong></h5>
                            <h5 class="my-3"><b> country : </b><strong>{{ ucwords($data->admission->country) }}</strong>
                            </h5>
                            <h5 class="my-3"><b> phone : </b><strong>{{ ucwords($data->admission->phone) }}</strong></h5>
                            <h5 class="my-3"><b> email : </b><strong>{{ $data->admission->email }}</strong></h5>
                            <h5 class="my-3"><b> gender : </b><strong>{{ ucwords($data->admission->gender) }}</strong>
                            </h5>
                            <h5 class="my-3"><b> Religion :
                                </b><strong>{{ ucwords($data->admission->religion) }}</strong></h5>
                        </div>
                        <div class="col-lg-4">
                            <div class="text-right">
                                @if ($data->admission->student_pic !== null)
                                    <img src="{{ asset('uploads/students/' . $data->admission->student_pic) }}"
                                        alt="" style="height: 150px">
                                @endif
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-body">
                    <div class="card-title">Attendance</div>
                    <div class="table-responsive">
                        <table id="attendance_table" class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Attendance</th>
                                    <th>Attendance Date</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($data->admission->studentAtd as $attendance)
                                    <tr>
                                        <td>
                                            @if ($attendance->attendence === 'present')
                                                <label class="label label-success">Present</label>
                                            @else
                                                <label class="label label-danger">Absent</label>
                                            @endif
                                        </td>
                                        <td>{{ ucwords($attendance->added_at) }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-body">
                    <div class="card-title">Exam Result</div>
                    <div class="table-responsive">
                        <table id="results_table" class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Exam Term</th>
                                    <th>Total Marks</th>
                                    <th>Obtained Marks</th>
                                    <th>Percentage</th>
                                    <th>Grade</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($data->admission->result as $result)
                                    <tr>
                                        <td>{{ ucwords($result->exam_type) }}</td>
                                        <td>{{ ucwords($result->total_marks) }}</td>
                                        <td>{{ ucwords($result->obtained_marks) }}</td>
                                        <td>{{ ucwords($result->percentage) }}</td>
                                        <td>{{ ucwords($result->grade) }}</td>
                                        <td>{{ ucwords($result->status) }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-body">
                    <div class="card-title">Fees Details</div>
                    <div class="table-responsive">
                        <table id="fee_table" class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Fee Type</th>
                                    <th>Fee Amount</th>
                                    <th>Fee Month</th>
                                    <th>Fee Due Date</th>
                                    <th>Paid At</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($data->fees->feedetails as $feeItem)
                                    <tr>
                                        <td>{{ ucwords($feeItem->fee_type) }}</td>
                                        <td>{{ ucwords($feeItem->fee_amount) }}</td>
                                        <td>{{ ucwords($data->fees->month_of) }}</td>
                                        <td>{{ ucwords($data->fees->due_date) }}</td>
                                        <td>{{ ucwords($data->fees->paid_at) }}</td>
                                        <td>{{ ucwords($data->fees->status) }}</td>
                                        <td>
                                            @if (!auth()->user()->is_student)
                                                <a class="btn btn-warning btn-xs"
                                                    href="{{ route('fees.print', $data->fees->id) }}"
                                                    target="_blank">Print</a>
                                            @endif
                                            <a class="btn btn-info btn-xs"
                                                href="{{ route('fees.show', $data->fees->id) }}">Show</a>
                                            @can('fee-edit')
                                                <a class="btn btn-primary btn-xs"
                                                    href="{{ route('fees.edit', $data->fees->id) }}">Pay</a>
                                            @endcan
                                            @can('fee-delete')
                                                {!! Form::open([
                                                    'method' => 'DELETE',
                                                    'route' => ['fees.destroy', $data->fees->id],
                                                    'style' => 'display:inline',
                                                ]) !!}
                                                {!! Form::submit('Delete', ['class' => 'btn btn-danger btn-xs']) !!}
                                                {!! Form::close() !!}
                                            @endcan
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
