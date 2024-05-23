@extends('layouts.app')

@section('title', 'Promote Student Create')

@section('content')
    <div class="row page-titles">
        <div class="col-md-5 align-self-center">
            <h4 class="text-themecolor">Promote Student Create</h4>
        </div>
        <div class="col-md-7 align-self-center text-right">
            <div class="d-flex justify-content-end align-items-center">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                    <li class="breadcrumb-item">Promote Student</li>
                    <li class="breadcrumb-item active">Create Promote Student</li>
                </ol>
                <a href="{{ route('promotes.index') }}" class="btn btn-info d-none d-lg-block m-l-15"><i class="fa fa-plus-circle"></i> Back</a>
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

                    <h5 class="card-title">Create Promote Student</h5>

                    <div id="alert"></div>
                    {!! Form::open(array('route' => 'promotes.store','method'=>'POST',
                        'class' => 'form-material m-t-40 create', 'id' => 'submitted')) !!}

                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-12">
                                <label class="font-medium">Class Name</label>
                                <select name="class_id" required class="form-control" id="class_id">
                                    <option value="">Select Option</option>
                                    @foreach($classes as $cl)
                                        <option value="{{ $cl->id }}">{{ $cl->name.' - '.$cl->section->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="table-responsive">

                        <table class="table table-striped">
                            <thead>
                            <tr>
                                <th>No</th>
                                <th>Class Name</th>
                                <th>Roll No</th>
                                <th>Student Name</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                            <tbody id="tb">

                            </tbody>
                        </table>
                    </div>

                    <button type="submit" class="btn btn-info waves-effect waves-light m-r-10">Submit</button>
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
@endsection

@section('javascript')
    <script>
        var students = null
        $('#class_id').change( () => {
            $('#tb').html('')
            var id = $('#class_id').val()
            $.ajax({
                url: "{{ config('app.url') }}/getStudents/"+id,
                type: 'GET',
                dataType: 'json', // added data type
                success: function(res) {
                    students = res
                    $.each(res, (index, value) => {
                        var html = '<tr>\n' +
                            '                                        <td>'+(index + 1)+'</td>\n' +
                            '                                        <td>'+value._class.name+' - '+value._class.section.name+'</td>\n' +
                            '                                        <td>'+value.roll_no+'</td>\n' +
                            '                                        <td>'+value.name+'</td>\n' +
                            '                                        <td><input type="checkbox" id="chk_'+value.id+'"></td>\n' +
                            '                                    </tr>'
                        $('#tb').append(html)
                    })
                }
            });
        })

        $(document).on('submit', '#submitted', (event) => {
            event.preventDefault()

            var local_students = []

            $.each(students, (i, v) => {
                var chk = $('#chk_'+v.id).is(':checked')
                if (chk === true){
                    local_students.push({ 'student': v, 'promoted': 'promoted' })
                }
                else{
                    local_students.push({ 'student': v, 'promoted': 'demoted' })
                }
            })

            $.ajax({
                url: '{{  route('promotes.store') }}',
                type: 'post',
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                data: {local_students:local_students},
                success: function(response) {
                    if (response.status === true){
                        $('#alert').html('<div class="alert alert-primary">'+response.msg+'</div>')
                        location.reload();
                    }
                    else {
                        $('#alert').html('<div class="alert alert-danger">'+response.msg+'</div>')
                    }
                },
                error: function (jqXHR) {
                    $('#alert').html('<div class="alert alert-danger">'+jqXHR+'</div>')
                }
            });
        })
    </script>
@endsection
