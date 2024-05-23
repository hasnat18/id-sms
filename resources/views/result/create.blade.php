@extends('layouts.app')

@section('title', 'Exam Result Create')

@section('content')
    <div class="row page-titles">
        <div class="col-md-5 align-self-center">
            <h4 class="text-themecolor">Exam Result Create</h4>
        </div>
        <div class="col-md-7 align-self-center text-right">
            <div class="d-flex justify-content-end align-items-center">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                    <li class="breadcrumb-item">Exam Results</li>
                    <li class="breadcrumb-item active">Create Exam Result</li>
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

                    <h5 class="card-title">Create Exam Result</h5>


                    {!! Form::open(array('route' => 'results.store','method'=>'POST',
                        'class' => 'form-material m-t-40 create', 'id' => 'submitted')) !!}

                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-4">
                                    <label class="font-medium">Class Name</label>
                                    <select name="class_id" required class="form-control" id="class_id">
                                        <option value="">Select Option</option>
                                        @foreach($classes as $cl)
                                            <option value="{{ $cl->id }}">{{ $cl->name.' - '.$cl->section->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <!--<div class="col-md-4">-->
                                <!--    <label class="font-medium">Student Name</label>-->
                                <!--    <select name="student_id" required class="form-control" id="student_id">-->
                                <!--        <option value="">Select Option</option>-->
                                <!--    </select>-->
                                <!--</div>-->
                                <div class="col-md-4">
                                    <label class="font-medium">Exam Type</label>
                                    <select name="exam_type" required class="form-control" id="exam_type">
                                        <option value="">Select Option</option>
                                        <option value="mid-term">Mid Term</option>
                                        <option value="final-term">Final Term</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="table-responsive">

                            <table class="table table-striped">
                                <thead id="resultTableHeader">
                                </thead>
                                <tbody id="resultTableBody">

                                </tbody>
                            </table>
                        </div>
                        
                        <input type="hidden" name="totalStudent" id="totalStudent" value="" />
                        <input type="hidden" name=="totalSubjects" id="totalSubjects" value="" />

                        <button type="submit" class="btn btn-info waves-effect waves-light m-r-10">Submit</button>
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
@endsection

@section('javascript')

<script>
    
    var subjects = null
    $('#class_id').on('change', function () {
        var classId = $(this).val();
        fetchStudents(classId);
    });
    
    // fetch student and subjects
    function fetchStudents(classId) {
    if (classId) {
        $.ajax({
            type: 'GET',
            url: "{{ route('getSubjectsAndStudents') }}",
            data: {
                _token: '{{ csrf_token() }}',
                classId: classId
            },
            success: function (data) {
                if (data.success == true) {
                    var subjectData = data.subject ? data.subject : [];
                    var studentData = data.student ? data.student : [];
                    
                    $("#totalStudent").val(studentData.length);
                    $("#totalSubjects").val(subjectData.length);
                    
                    var tableHead = "<tr>";
                    tableHead += "<td>Sr No.</td>";
                    tableHead += "<td>Student Name</td>";
                    subjectData.forEach(function (item) {
                        var subName = item.get_subject.name ? item.get_subject.name : '';
                        tableHead += "<td>" + subName + "</td>";
                    });
                    tableHead += "<td>Obtained Marks</td>";
                    tableHead += "<td>Percentage</td>";
                    tableHead += "</tr>";
                    $("#resultTableHeader").html(tableHead);

                    var tableBody = "";

                    studentData.forEach(function (item, studentIndex) {
                        var countBody = studentIndex + 1; // Start counting from 1

                        var stdName = item.student_name ? item.student_name : '';
                        tableBody += "<tr>";
                        tableBody += "<td>" + countBody + "</td>";
                        tableBody += "<td>" + stdName + "</td>";
                        
                        subjectData.forEach(function (subject) {
                            var subName = subject.get_subject.name ? subject.get_subject.name : '';
                            
                            var subjectId = subject.get_subject.id;
                            var inputId = 'marks_' + subjectId + '_' + item.id;

                            tableBody += "<td><input type='text' style='width:40px;' studentId='"+item.id+"' name='student["+item.id+"]["+subjectId+"]' id='" + inputId + "' class='subject-marks'></td>";

                        });

                        // Initialize the obtained marks and percentage for each student
                        tableBody += "<td id='obtained_" + item.id + "'>0</td>";
                        tableBody += "<td id='percentage_" + item.id + "'>0%</td>";
                        tableBody += "</tr>";
                    });

                    $("#resultTableBody").html(tableBody);
                } else {
                    alert("Record not found");
                }
            }
        });
    } else {
        alert("Please select class.");
    }
}

    // Calculate obtained marks and percentage dynamically
    $(document).on('focusout', '.subject-marks', function () {
        
        var subjectStudentId = $(this).attr('id');
        var studentId        = $(this).attr('studentId');
        var marks            = $(this).val();
        
        if(marks != ''){
            
            var obtMarks = $("#obtained_"+studentId).text();
            var totalObtaindMarks = (parseInt(obtMarks)+parseInt(marks));
            $("#obtained_"+studentId).text(totalObtaindMarks);
            var totalMarks = 700;
            // Update the obtained marks for the current student
            var percentage = (totalObtaindMarks / totalMarks) * 100;
            $('#percentage_'+studentId).html(percentage.toFixed(2) + '%');
            
        }
    });
    
    $(document).ready(function() {
        
        // submit form
        $(document).on('submit', '#submitted', (event) => {
            event.preventDefault()
            
            var formData = $("#submitted").serializeArray();
            var totalStudent  = $("#totalStudent").val();
            var totalSubjects = $("#totalSubjects").val();

            $.ajax({
                url: '{{  route('results.store') }}',
                type: 'post',
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                data: {
                        totalStudent:totalStudent, 
                        totalSubjects:totalSubjects, 
                        formData: formData
                },
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
                }
            });
        });
          
    })
        
</script>
@endsection
