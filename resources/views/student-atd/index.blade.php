@extends('layouts.app')

@section('title', 'Student Attendance')

@section('content')
    <div class="row page-titles">
        <div class="col-md-5 align-self-center">
            <h4 class="text-themecolor">Student Attendance</h4>
        </div>
        <div class="col-md-7 align-self-center text-right">
            <div class="d-flex justify-content-end align-items-center">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                    <li class="breadcrumb-item active">Student Attendance</li>
                </ol>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-body">

                    @if ($message = Session::get('success'))
                        <div class="alert alert-success">
                            <p>{{ $message }}</p>
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

                    <h5 class="card-title">Student Attendance</h5>

                    <div class="row mt-4">
                        <div class="col-lg-4">
                            <div class="d-flex">
                                <label class="font-medium">Select Any Class</label>
                                <select id="selectedClass" class="form-control">
                                    <option value="">Select Please</option>
                                    @foreach($class as $c)
                                        <option value="{{ $c->id }}">{{ $c->name.' - '.$c->section->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="col-lg-4">
                            <div class="d-flex">
                                <label class="font-medium">Select Any Date</label>
                                <input type="date" id="month_of" class="form-control">
                            </div>
                        </div>

                        <div class="col-lg-4">
                            <button class="btn btn-primary" onclick="saveAtd()">Save</button>
                        </div>
                    </div>
                    <div class="table-responsive">

                        <table class="table table-striped">
                            <thead>
                            <tr>
                                <th>No</th>
                                <th>Roll Number</th>
                                <th>Name</th>
                                <th width="280px">Action</th>
                            </tr>
                            </thead>
                            <tbody id="tb">

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('javascript')

    <script type="text/javascript">

        // $.ajaxSetup({
        //     headers: {
        //         'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        //     }
        // });

        var dataArr = '';
        function saveAtd(){
            if (dataArr === ''){
                alert('No class selected')
                return;
            }
            var date = $('#month_of').val()
            if (date === ''){
                alert('No date selected')
                return;
            }

            var arr = [];

            $.each(dataArr, (i, v) => {
                var chk = $('#chk_'+v.id).is(':checked')
                if (chk === true){
                    arr.push({ 'id': v.id, 'status': 'present', 'date': date })
                }
                else{
                    arr.push({ 'id': v.id, 'status': 'absent', 'date': date })
                }
            })

            if (arr.length === 0){
                alert('No data to save')
                return;
            }

            $.ajax({
                url: 'save-attendance',
                type: 'post',
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                data: {date:date, data: arr},
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
        }

        $('#selectedClass').change( () => {
            var id = $('#selectedClass').val()
            $('tb').html('')
            $.ajax({
                url: "getStudentsFromClass/"+id,
                type: 'GET',
                dataType: 'json', // added data type
                async: false,
                success: function(res) {
                    dataArr = res
                    $.each(res, (i, v) => {
                        var html = ' <tr>\n' +
                            '                                    <td>'+(i+1)+'</td>\n' +
                            '                                    <td>'+v.roll_no+'</td>\n' +
                            '                                    <td>'+v.name+'</td>\n' +
                            '                                    <td><input type="checkbox" value="'+v.id+'" id="chk_'+v.id+'"></td>\n' +
                            '                                </tr>';
                        $('#tb').append(html)
                    })
                }
            })
        })
    </script>

@endsection
