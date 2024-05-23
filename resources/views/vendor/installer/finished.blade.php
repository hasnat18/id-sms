@extends('vendor.installer.layouts.master')

@section('template_title')
    {{ trans('installer_messages.final.templateTitle') }}
@endsection

@section('title')
    <i class="fa fa-flag-checkered fa-fw" aria-hidden="true"></i>
    {{ trans('installer_messages.final.title') }}
@endsection

@section('container')

	<p><strong><small>{{ trans('installer_messages.final.log') }}</small></strong></p>
	<pre><code>{{ $finalStatusMessage }}</code></pre>

	<p><strong><small>Admin Login</small></strong></p>
	<pre>
		<code>
			Email: super@admin.com
			Password: admin123
		</code>
	</pre>

    <div class="buttons">
        <a href="{{ url('/') }}" class="button">{{ trans('installer_messages.final.exit') }}</a>
    </div>

@endsection
