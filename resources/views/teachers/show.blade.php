@extends('layouts.app')

@section('title', 'Teacher Details')

@section('content')

    <div class="row page-titles">
        <div class="col-md-5 align-self-center">
            <h4 class="text-themecolor">Teacher Details</h4>
        </div>
        <div class="col-md-7 align-self-center text-right">
            <div class="d-flex justify-content-end align-items-center">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                    <li class="breadcrumb-item active">Teacher Details</li>
                </ol>
                <a href="{{ route('teachers.index') }}" class="btn btn-info d-none d-lg-block m-l-15"><i
                        class="fa fa-plus-circle"></i> Back</a>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">
                        {{ $data->name }}
                    </h5>
                    <div class="float-right">
                        @if ($data->id_proof !== null)
                            <img src="{{ asset('uploads/staffs/' . $data->id_proof) }}" alt=""
                                class="h-50 shadow-lg" width="100" height="100">
                        @endif
                    </div>
                    <p class="card-text">Gender: <strong>{{ $data->gender }}</strong></p>
                    <p class="card-text">Date of birth: <strong>{{ $data->dob }}</strong></p>
                    <p class="card-text">Address: <strong>{{ $data->address }}</strong></p>
                    <p class="card-text">Phone: <strong>{{ $data->phone }}</strong></p>
                    <p class="card-text">Email: <strong>{{ $data->email }}</strong></p>
                    <p class="card-text">Joining Date: <strong>{{ $data->joining_date }}</strong></p>
                    <p class="card-text">Salary: <strong>{{ $data->salary }}</strong></p>
                    <p class="card-text">Transportation: @isset($data->transport->vehicle_number)
                            {{ $data->transport->vehicle_number . ' - ' . $data->transport->vehicle_model }}
                        @endisset
                    </p>
                    <p class="card-text">Department: @isset($data->users->department->name)
                            <span
                                class="badge badge-primary text-white"><strong>{{ $data->users->department->name }}</strong></span>
                        @endisset
                    </p>
                    <p class="card-text">Role: <strong>{{ $userRole->name }}</strong></p>

                    <p class="card-text">Permissions:
                        @foreach ($rolePermissions as $p)
                            <label class="badge badge-info">{{ $p->name }}</label>
                        @endforeach
                    </p>
                    <p class="card-text">Added By:
                        <strong>{{ \App\Models\User::where('id', $data->added_by)->pluck('name')->first() }}</strong>
                    </p>
                    <p class="card-text">Created At: <strong>{{ $data->created_at->format('M d, Y') }}</strong></p>
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
                                @foreach ($data->staff_atds as $attendance)
                                    <tr>
                                        <td>
                                            @if ($attendance->status === 'present')
                                                <label class="label label-success">Present</label>
                                            @elseif($attendance->status === 'leave')
                                                <label class="label label-warning">Leave</label>
                                            @elseif($attendance->status === 'late')
                                                <label class="label label-megna">Late</label>
                                            @else
                                                <label class="label label-danger">Absent</label>
                                            @endif
                                        </td>
                                        <td>{{ ucwords($attendance->add_at) }}</td>
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
                    <div class="card-title">Assigned Subjects</div>
                    <div class="table-responsive">
                        <table id="myTable" class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Class</th>
                                    <th>Name</th>
                                    <!--<th>No of Student</th>-->
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($data->subjects as $subject)
                                    <tr>
                                        <td>{{ $subject->_class->name }}</td>
                                        <td>{{ $subject->name }}</td>
                                        <!--<td>{{ $subject->_class->name }}</td>-->
                                        <td>
                                            <form id="revoke-subject-form-{{ $subject->id }}"
                                                action="{{ route('revokeSubject', ['staffid' => $data->id, 'id' => $subject->id]) }}"
                                                method="POST" style="display: none;">
                                                @csrf
                                            </form>
                                            <button
                                                onclick="event.preventDefault(); document.getElementById('revoke-subject-form-{{ $subject->id }}').submit();"
                                                class="btn btn-danger">Revoke Subject</button>
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

    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-body">
                    <div class="card-title">Salaries</div>
                    <div class="table-responsive">
                        <table id="fee_table" class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Salary</th>
                                    <th>Deduction</th>
                                    <th>Deduction Days</th>
                                    <th>Salary Month</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($data->salaries as $salary)
                                    <tr>
                                        <td>
                                            {{ ucwords($salary->salary) }}
                                        </td>
                                        <td>
                                            {{ ucwords($salary->deduction) }}
                                        </td>
                                        <td>
                                            {{ ucwords($salary->deduction_days) }}
                                        </td>
                                        <td>
                                            {{ ucwords($salary->month_of) }}
                                        </td>
                                        <td>
                                            {{ ucwords($salary->status) }}
                                        </td>
                                        <td>
                                            <a class="btn btn-info mx-2"
                                                href="{{ route('salaries.show', $salary->id) }}">Show</a>
                                            @can('salary-edit')
                                                <a class="btn btn-primary mx-2"
                                                    href="{{ route('salaries.edit', $salary->id) }}">Edit</a>
                                            @endcan
                                            @can('salary-delete')
                                                {!! Form::open([
                                                    'method' => 'DELETE',
                                                    'route' => ['salaries.destroy', $salary->id],
                                                    'style' => 'display:inline',
                                                ]) !!}
                                                {!! Form::submit('Delete', ['class' => 'btn btn-danger']) !!}
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
