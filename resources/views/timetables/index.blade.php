@extends('layouts.app')

@section('title', 'Timetable')

@section('content')

    <style>
        body {
            font-family: Tahoma;
        }

        /* declare a 7 column grid on the table */
        #calendar {
            width: 100%;
            display: grid;
            grid-template-columns: repeat(7, 1fr);
        }

        #calendar tr, #calendar tbody {
            grid-column: 1 / -1;
            display: grid;
            grid-template-columns: repeat(8, 1fr);
            width: 100%;
        }

        #calendar a {
            color: #8e352e;
            text-decoration: none;
        }

        #calendar td, #calendar th {
            padding: 2px;
            box-sizing:border-box;
            border: 1px solid #ccc;
        }

        #calendar .weekdays {
            background: #004274;
        }


        #calendar .weekdays th {
            text-align: center;
            text-transform: uppercase;
            line-height: 20px;
            border: none !important;
            padding: 10px 6px;
            color: #fff;
            font-size: 13px;
        }

        #calendar td {
            min-height: 50px;
            display: flex;
            flex-direction: column;
        }

        #calendar .days li:hover {
            background: #d3d3d3;
        }





        #calendar .other-month {
            background: #f5f5f5;
            color: #666;
        }

        /* ============================
                        Mobile Responsiveness
           ============================*/


        @media(max-width: 768px) {

            #calendar .weekdays, #calendar .other-month {
                display: none;
            }

            #calendar li {
                height: auto !important;
                border: 1px solid #ededed;
                width: 100%;
                padding: 10px;
                margin-bottom: -1px;
            }

            #calendar, #calendar tr, #calendar tbody {
                grid-template-columns: 1fr;
            }

            #calendar  tr {
                grid-column: 1 / 2;
            }

            #calendar .date {
                align-self: flex-start;
            }
        }
    </style>

    <div class="row page-titles">
        <div class="col-md-5 align-self-center">
            <h4 class="text-themecolor">Timetable</h4>
        </div>
        <div class="col-md-7 align-self-center text-right">
            <div class="d-flex justify-content-end align-items-center">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                    <li class="breadcrumb-item active">Timetable</li>
                </ol>
                @can('time-table')
                    <a href="{{ route('time-tables.create') }}" class="btn btn-info d-none d-lg-block m-l-15"><i class="fa fa-plus-circle"></i> Create New</a>
                @endcan
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

                    <div class="row">
{{--                        <div class="col-lg-12">--}}
{{--                            <div class="form-group">--}}
{{--                                <div class="row">--}}
{{--                                    <label class="col-sm-12">Class Name</label>--}}
{{--                                    <div class="col-sm-12 validate">--}}
{{--                                        <select required name="__class_id" class="form-control" id="class_id">--}}
{{--                                            <option value="">Select Option</option>--}}
{{--                                            @foreach($classes as $cl)--}}
{{--                                                <option value="{{ $cl->id }}">{{ $cl->name.' - '.$cl->section->name }}</option>--}}
{{--                                            @endforeach--}}
{{--                                        </select>--}}
{{--                                    </div>--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                        </div>--}}

                        <div class="col-lg-12">
{{--                            <table id="calendar">--}}
{{--                                <tr class="weekdays">--}}
{{--                                    <th scope="col">Timeslot</th>--}}
{{--                                    <th scope="col">Monday</th>--}}
{{--                                    <th scope="col">Tuesday</th>--}}
{{--                                    <th scope="col">Wednesday</th>--}}
{{--                                    <th scope="col">Thursday</th>--}}
{{--                                    <th scope="col">Friday</th>--}}
{{--                                    <th scope="col">Saturday</th>--}}
{{--                                    <th scope="col">Sunday</th>--}}
{{--                                </tr>--}}
{{--                                <tr class="days" id="tr-data">--}}

{{--                                </tr>--}}
{{--                            </table>--}}
                            <h5 class="card-title">Timetable list</h5>
                            <div class="table-responsive">

                                <table class="table table-striped" id="myTable">
                                    <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Class Name</th>
                                        <th>Subject Name</th>
                                        <th>Day</th>
                                        <th>TimeSlot</th>
                                        <th>Action</th>
                                    </tr>
                                    </thead>
                                    <tbody id="tb">
                                        @foreach($timetable as $d)
                                            <tr>
                                                <td>{{ $d->id }}</td>
                                                <td>{{ $d->subject->_class->name.' - '.$d->subject->_class->section->name }}</td>
                                                <td>{{ $d->subject->name }}</td>
                                                <td>{{ $d->day }}</td>
                                                <td>{{ $d->start_time.' - '.$d->end_time }}</td>
                                                <td>
{{--                                                    @can('time-table-edit')--}}
{{--                                                        <a class="btn btn-primary" href="{{ route('time-tables.edit',$d->id) }}">Edit</a>--}}
{{--                                                    @endcan--}}
                                                    @can('time-table-delete')
                                                        {!! Form::open(['method' => 'DELETE','route' => ['time-tables.destroy', $d->id],'style'=>'display:inline']) !!}
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
        </div>
    </div>

@endsection

@section('javascript')
    <script>
        // $('#class_id').change( () => {
        //     $('#tb').html('')
        //     var id = $('#class_id').val()
        //     $.ajax({
        //         url: site_url+"/getTimetable/"+id,
        //         type: 'GET',
        //         dataType: 'json', // added data type
        //         success: function(res) {
        //             $.each(res, (i, v) => {
        //                 console.log(res)
        //                 var html = '<tr>\n' +
        //                     '                                            <td>'+(i+1)+'</td>\n' +
        //                     '                                            <td>'+v.subject._class.name+'</td>\n' +
        //                     '                                            <td>'+v.subject.name+'</td>\n' +
        //                     '                                            <td>'+v.day+'</td>\n' +
        //                     '                                            <td>'+v.start_time+' - '+v.end_time+'</td>\n' +
        //                     '                                            <td></td>\n' +
        //                     '                                        </tr>'
        //                 $('#tb').append(html)
        //             })
        //         }
        //     });
        // })
    </script>
@endsection




