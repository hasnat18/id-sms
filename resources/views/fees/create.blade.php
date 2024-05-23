@extends('layouts.app')

@section('title', 'Add Fees')

@section('content')
    <div class="row page-titles">
        <div class="col-md-5 align-self-center">
            <h4 class="text-themecolor">Add Department</h4>
        </div>
        <div class="col-md-7 align-self-center text-right">
            <div class="d-flex justify-content-end align-items-center">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                    <li class="breadcrumb-item active">Fees</li>
                    <li class="breadcrumb-item active">Add Fees</li>
                </ol>
                <a href="{{ route('fees.index') }}" class="btn btn-info d-none d-lg-block m-l-15"><i class="fa fa-plus-circle"></i> Back</a>
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

                    <h5 class="card-title">Create Fees</h5>
                    {!! Form::open(array('route' => 'fees.store','method'=>'POST', 'class' => 'form-material m-t-40 create', 'id' => 'submitForm')) !!}
                        <div class="form-group">
                            <div class="row">
                                
                                
                                {{--  --}}
                                <div class="col-sm-3 mb-4">
                                    <label class="col-sm-12"> Classes</label>
                                </div>
                                <div class="col-sm-9 mb-4">
                                    <div class="validate">
                                        <select class="form-control" id="class_id" name="class_id">
                                            <option value="">Select Option</option>
                                            @foreach($_classes as $c)
                                                <option value="{{ $c->id }}">{{ $c->name."-".$c->section->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                {{--  --}}

                                <div class="col-sm-3 mb-4">
                                    <label class="col-sm-12">All Students</label>
                                </div>
                                <div class="col-sm-9 mb-4">
                                    <div class="validate">
                                        <select class="form-control" required name="admission_id" id="student_id">
                                            <option value="">Select Please</option>
                                          
                                        </select>
                                    </div>
                                </div>

                                <br>

                                <div class="col-sm-3 mb-4">
                                    <label class="col-sm-12">Month Of</label>
                                </div>
                                <div class="col-sm-9 mb-4">
                                    <div class="col-sm-12 validate">
                                        <input type="month" name="month_of" required class="form-control">
                                    </div>
                                </div>

                                <br>

                                <div class="col-sm-3 mb-4">
                                    <label class="col-sm-12">Due Date</label>
                                </div>
                                <div class="col-sm-9 mb-4">
                                    <div class="col-sm-12 validate">
                                        <input type="date" name="due_date" required class="form-control">
                                    </div>
                                </div>

                                <br>

                                <div class="col-sm-12 mb-4">
                                    <h5 class="font-bold">Add Fees with type</h5>
                                </div>

                                <div class="col-sm-4 mb-4">
                                    <label class="col-sm-12">Fee Type</label>
                                    <div class="col-sm-12 validate">
                                        <select class="form-control"  name="fee_type" id="ft">
                                            <option value="">Select Please</option>
                                            <option value="admission">Admission</option>
                                            <option value="tuition">Tuition</option>
                                            <option value="transportation">Transportation</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-sm-4 mb-4">
                                    <label class="col-sm-12">Fees Amount</label>
                                    <div class="col-sm-12 validate">
                                        <input type="text" name="fee_amount"  placeholder="Fees Amount" class="form-control" id="am">
                                    </div>
                                </div>

                                <div class="col-sm-4 mb-4">
                                    <label class="col-sm-12"></label>
                                    <a href="javascript::void(0)" onclick="addFee()" class="btn btn-primary">Add Fee Type</a>
                                </div>

                            </div>
                        </div>

                        <table border="1" style="width: 100%;text-align: center;font-weight: bold;">
                           <thead>
                               <td>#</td>
                               <td>Fee Type</td>
                               <td>Fee Amount</td>
                           </thead>
                            <tbody style="font-weight: normal" id="tb">

                            </tbody>
                        </table>

                        <button type="submit" class="btn btn-info waves-effect waves-light m-r-10 mt-4">Submit</button>
                        {!! Form::close() !!}
            
                </div>
                
            </div>
        </div>
    </div>
@endsection


@section('javascript')

    <script type="text/javascript">
        var arr = [];
        function addFee() {
            var ft = document.getElementById("ft").value;
            var am = document.getElementById("am").value;
            if (ft === ''){
                alert('no fee type selected')
                return;
            }
            if (am === ''){
                alert('no amount given')
                return;
            }

            var count = arr.length
            if (count > 0){
                var chk = false;
                $.each(arr, (i, v) => {
                    if (v.type === ft){
                        alert('already added')
                        chk = true;
                    }
                })
                if (chk === true){
                    return;
                }
            }
            arr.push( { 'type':ft, 'amount':am } )

            $('#tb').html('')
            $.each(arr, (i, v) => {
                var html = '<tr>\n' +
                    '            <td>'+i+'</td>\n' +
                    '            <td>'+v.type+'</td>\n' +
                    '            <td>'+v.amount+'</td>\n' +
                    '            </tr>'
               $('#tb').append(html)
            })
        }

        $(document).on('submit', '#submitForm', (e) => {
            e.preventDefault()
            if (arr.length === 0){
                alert('No fees added')
                return;
            }

            var form = $('#submitForm');
            var formData = new FormData(form[0]);
            var conv = JSON.stringify(arr)
            formData.append('feeArr', conv)
            
           // Log relevant data
                console.log('Form Data:', formData);
                console.log('JSON Data:', conv);


            $.ajax({
                type: form.attr('method'),
                url: form.attr('action'),
                contentType: false,
                processData: false,
                dataType: 'json',
                data: formData,
                success: (response) => {
                    if(response.status === true){
                        alert(response.msg)
                        setTimeout(function(){ window.location = '{{ route('fees.index') }}' }, 1500);
                    }else{
                        alert(response.msg)
                    }
                },
                error: (err) => {
                    alert(err.statusText)
                }
            });

        })
        
      
$('#class_id').on('change', function () {
    var classId = $(this).val();
    fetchStudents(classId);
});

function fetchStudents(classId) {
    if (classId) {
        $.ajax({
            type: 'GET',
            url: "{{ route('fees.get-substudents') }}", // Replace with your route name
            data: {
                _token: '{{ csrf_token() }}',
                classId: classId
            },
            success: function (data) {
                var selectOptions = $('#student_id');
                selectOptions.empty();
                selectOptions.append('<option value="">Select Student</option>');
                $.each(data, function (key, student) {
                    selectOptions.append($('<option>', {
                        value: student.id,
                        text: student.student_name // Replace with the actual student name property
                    }));
                });
            }
        });
    } else {
        $('#student_id').empty();
        $('#student_id').append('<option value="">Select Student</option>');
    }
}


    </script>

@endsection

