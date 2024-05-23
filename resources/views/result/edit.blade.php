@extends('layouts.app')

@section('title', 'Exam Result Edit')

@section('content')
    <div class="row page-titles">
        <div class="col-md-5 align-self-center">
            <h4 class="text-themecolor">Exam Result Edit</h4>
        </div>
        <div class="col-md-7 align-self-center text-right">
            <div class="d-flex justify-content-end align-items-center">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                    <li class="breadcrumb-item">Exam Results</li>
                    <li class="breadcrumb-item active">Edit Exam Result</li>
                </ol>
                <a href="{{ route('results.index') }}" class="btn btn-info d-none d-lg-block m-l-15"><i class="fa fa-plus-circle"></i> Back</a>
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

                    <h5 class="card-title">Edit Exam Result</h5>


                    {!! Form::model($data, array('route' => ['results.update', $data->id],'method'=>'PATCH',
                        'class' => 'form-material m-t-40 create', 'id' => 'submitted')) !!}

                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-4">
                                <label class="font-medium">Class Name</label>
                                <select name="class_id" required disabled class="form-control" id="class_id">
                                    <option value="">Select Option</option>
                                    @foreach($classes as $cl)
                                        <option value="{{ $cl->id }}" {{ $data->class_id === $cl->id ? 'selected' : '' }}>{{ $cl->name.' - '.$cl->section->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label class="font-medium">Student Name</label>
                                <select name="student_id" required disabled class="form-control" id="student_id">
                                    <option value="">Select Option</option>
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label class="font-medium">Exam Type</label>
                                <select name="exam_type" disabled required class="form-control" id="exam_type">
                                    <option value="">Select Option</option>
                                    <option value="mid-term" {{ $data->exam_type === 'mid-term' ? 'selected' : '' }}>Mid Term</option>
                                    <option value="final-term" {{ $data->exam_type === 'final-term' ? 'selected' : '' }}>Final Term</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="table-responsive">

                        <table class="table table-striped">
                            <thead>
                            <tr>
                                <th>No</th>
                                <th>Subjects</th>
                                <th>Obt. Marks</th>
                                <th>Total Marks</th>
                            </tr>
                            </thead>
                            <tbody id="tb">
                                @foreach($rds as $key => $rd)
                                    <tr>
                                        <td>{{ $key+1 }}</td>
                                        <td>{{ $rd->subject_name }}</td>
                                        <td><input type="text" value="{{ $rd->obtained_marks }}" id="obt_{{ $rd->id }}"></td>
                                        <td><input type="text" value="{{ $rd->subject_marks }}" id="tt_{{ $rd->id }}"></td>
                                    </tr>
                                @endforeach
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
        var result_details = {!! $rds !!}
        function onload(){
            $('#student_id').html('')
            var id = $('#class_id').val()
            $.ajax({
                url: site_url+"/getSubjectsAndStudents/"+id,
                type: 'GET',
                dataType: 'json', // added data type
                success: function(res) {
                    $.each(res.students, (index, value) => {
                        $('#student_id').append('<option value="'+value.id+'">'+value.name+'</option>')
                    })
                }
            });
        }

        window.onload = onload();

        $(document).on('submit', '#submitted', (event) => {
            event.preventDefault()

            var local_result_details = []
            var total = 0
            var obt = 0

            $.each(result_details, (i, v) => {
                total = total + parseInt($('#tt_'+v.id).val())
                obt = obt + parseFloat($('#obt_'+v.id).val())
                local_result_details.push({ 'id':v.id, 'subject_name': v.subject_name, 'obt_marks': $('#obt_'+v.id).val(), 'total_marks': $('#tt_'+v.id).val() })
            })

            var per = (obt/total)*100

            var formData = {
                total, obt, per
            }

            $.ajax({
                url: '{{  route('results.update', $data->id) }}',
                type: 'PATCH',
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                data: {local_result_details:local_result_details, formData:formData},
                success: function(response) {
                    if (response.status === true){
                        alert(response.msg)
                        location.reload();
                    }
                    else {
                        alert(response.msg)
                    }
                },
                error: function (jqXHR) {
                    console.log(jqXHR);
                }
            });
        })
    </script>
@endsection
