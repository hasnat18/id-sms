@extends('layouts.app')

@section('title', 'Staff Details')

@section('content')
    <div class="row page-titles">
        <div class="col-md-5 align-self-center">
            <h4 class="text-themecolor">Staff Details</h4>
        </div>
        <div class="col-md-7 align-self-center text-right">
            <div class="d-flex justify-content-end align-items-center">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                    <li class="breadcrumb-item">Staffs</li>
                    <li class="breadcrumb-item active">Staff Details</li>
                </ol>
                <a href="{{ route('staffs.index') }}" class="btn btn-info d-none d-lg-block m-l-15"><i
                        class="fa fa-plus-circle"></i> Back</a>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-8 mx-auto">
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
                    <p class="card-text">Bus Incharge:
                        @if ($data->is_bus_incharge === 0)
                            <label class="badge badge-danger">NO</label>
                        @else
                            <label class="badge badge-success">YES</label>
                        @endif
                    </p>
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

@endsection
