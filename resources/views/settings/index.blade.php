@extends('layouts.app')

@section('title', 'System Settings')

@section('content')

    <div class="row page-titles">
        <div class="col-md-5 align-self-center">
            <h4 class="text-themecolor">System Settings</h4>
        </div>
        <div class="col-md-7 align-self-center text-right">
            <div class="d-flex justify-content-end align-items-center">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                    <li class="breadcrumb-item active">System Settings</li>
                </ol>
            </div>
        </div>
    </div>

    <form method="POST" action="{{ route('settings.update') }}" enctype="multipart/form-data" class="form-material">
        @csrf
        @method('PUT')
        <div class="row">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Site Settings</h5>
                        <div class="form-group mt1">
                            <label for="site_title" class="form-label">School Name</label>
                            <input type="text" name="site_title" id="site_title"
                                class="form-control @error('site_title') is-invalid @enderror"
                                value="{{ $site_settings['site_title']['value'] ?? old('site_title') }}" required
                                autocomplete="site_title" autofocus>
                            @error('site_title')
                                <span class="text-danger" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="form-group mt-3">
                            <label for="site_tagline" class="form-label">School Tagline</label>
                            <input type="text" name="site_tagline" id="site_tagline"
                                class="form-control @error('site_tagline') is-invalid @enderror"
                                value="{{ $site_settings['site_tagline']['value'] ?? old('site_tagline') }}" required
                                autocomplete="site_tagline" autofocus>
                            @error('site_tagline')
                                <span class="text-danger" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="form-group mt1">
                            <label for="site_address" class="form-label">School Address</label>
                            <input type="text" name="site_address" id="site_address"
                                class="form-control @error('site_address') is-invalid @enderror"
                                value="{{ $site_settings['site_address']['value'] ?? old('site_address') }}" required
                                autocomplete="site_address" autofocus>
                            @error('site_address')
                                <span class="text-danger" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="form-group mt-3">
                            <div class="d-flex align-items-start align-items-sm-center gap-4">
                                <label for="site_logo" class="form-label">School Logo</label>
                                <input type="file" name="site_logo" id="site_logo">
                            </div>
                        </div>
                        @isset($site_settings['site_logo']['value'])
                            <div class="form-group mt-3">
                                <img src="{{ get_logo() }}" alt="{{ $site_settings['site_title']['value'] }}" width="30%">
                            </div>
                        @endisset
                    </div>
                </div>
            </div>

            <div class="col-md-6 mt-3 mt-sm-3 mt-md-3 mt-lg-0">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Fee Information</h5>
                        <div class="form-group mt1">
                            <label for="fee_bank_name" class="form-label">Bank Name</label>
                            <input type="text" name="fee_bank_name" id="fee_bank_name"
                                class="form-control @error('fee_bank_name') is-invalid @enderror"
                                value="{{ $site_settings['fee_bank_name']['value'] ?? old('fee_bank_name') }}" required
                                autocomplete="fee_bank_name" autofocus>
                            @error('fee_bank_name')
                                <span class="text-danger" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="form-group mt1">
                            <label for="fee_bank_account" class="form-label">Bank Account No</label>
                            <input type="text" name="fee_bank_account" id="fee_bank_account"
                                class="form-control @error('fee_bank_account') is-invalid @enderror"
                                value="{{ $site_settings['fee_bank_account']['value'] ?? old('fee_bank_account') }}" required
                                autocomplete="fee_bank_account" autofocus>
                            @error('fee_bank_account')
                                <span class="text-danger" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="form-group mt1">
                            <label for="fee_bank_branch" class="form-label">Bank Branch Address</label>
                            <input type="text" name="fee_bank_branch" id="fee_bank_branch"
                                class="form-control @error('fee_bank_branch') is-invalid @enderror"
                                value="{{ $site_settings['fee_bank_branch']['value'] ?? old('fee_bank_branch') }}" required
                                autocomplete="fee_bank_branch" autofocus>
                            @error('fee_bank_branch')
                                <span class="text-danger" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                         
                    </div>
                </div>


                <div class="card mt-3">
                    <div class="card-body">
                        <div class="row mx-auto ">
                            <div class="col mt-2">
                                <button type="submit" class="btn btn-primary me-2">Save Settings</button>
                                <a href="{{ url()->previous() }}" class="btn btn-outline-secondary">Cancel</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>

    @endsection
