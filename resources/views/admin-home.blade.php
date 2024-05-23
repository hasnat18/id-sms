<div class="col-lg-3 mb-2 order-0">
    <div class="card bg-light">
        <div class="card-body">
            <h5 class="card-title">Total Departments</h5>
            <p class="card-text display-5">{{ $dep }}</p>
        </div>
    </div>
</div>

<div class="col-lg-3 mb-2 order-0">
    <div class="card bg-light">
        <div class="card-body">
            <h5 class="card-title">Total Teachers</h5>
            <p class="card-text display-5">{{ count($teacher) }}</p>
        </div>
    </div>
</div>

<div class="col-lg-3 mb-2 order-0">
    <div class="card bg-light">
        <div class="card-body">
            <h5 class="card-title">Total Students</h5>
            <p class="card-text display-5">{{ $stu }}</p>
        </div>
    </div>
</div>

<div class="col-lg-3 mb-2 order-0">
    <div class="card bg-light">
        <div class="card-body">
            <h5 class="card-title">Total Staffs</h5>
            <p class="card-text display-5">{{ $staff }}</p>
        </div>
    </div>
</div>

<div class="col-lg-3 mb-2 order-0">
    <div class="card bg-light">
        <div class="card-body">
            <h5 class="card-title">Pending Salaries</h5>
            <p class="card-text display-5">{{ $pen_salaries }}</p>
        </div>
    </div>
</div>

<div class="col-lg-3 mb-2 order-0">
    <div class="card bg-light">
        <div class="card-body">
            <h5 class="card-title">Pending Fees</h5>
            <p class="card-text display-5">{{ $pen_fee }}</p>
        </div>
    </div>
</div>

<div class="col-lg-3 mb-2 order-0">
    <div class="card bg-light">
        <div class="card-body">
            <h5 class="card-title">Staff Pending Leaves</h5>
            <p class="card-text display-5">{{ $pen_Sleaves }}</p>
        </div>
    </div>
</div>

<div class="col-lg-3 mb-2 order-0">
    <div class="card bg-light">
        <div class="card-body">
            <h5 class="card-title">Student Pending Leaves</h5>
            <p class="card-text display-5">{{ $pen_stuleaves }}</p>
        </div>
    </div>
</div>


{{-- REG ADM CHART --}}
<div class="col-lg-12 mb-2 order-0">
    <div class="card">
        <div class="d-flex align-items-end row">
            <div class="col-sm-12">
                <div class="card-body">
                    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.5.0/Chart.min.js"></script>
                    <canvas id="MyChart" style="width:100%;max-width:100%"></canvas>
                    <script type="text/javascript">
                        var xValues = ["Admissions", "Pending Admissions", "Registrations", "Pending Registrations", ];
                        var yValues = [{{ $admission }}, {{ $admission_p }}];
                        new Chart("MyChart", {
                            type: "line",
                            data: {
                                labels: xValues,
                                datasets: [{
                                    fill: false,
                                    lineTension: 0,
                                    backgroundColor: "rgba(0,0,255,1.0)",
                                    borderColor: "rgba(0,0,255,0.1)",
                                    data: yValues
                                }]
                            },
                            options: {
                                legend: {
                                    display: false
                                },
                                scales: {
                                    yAxes: [{
                                        ticks: {
                                            min: {{ $minmax->min }},
                                            max: {{ $minmax->max }}
                                        }
                                    }],
                                },
                                title: {
                                    display: true,
                                    text: "Registration And Admission"
                                }
                            }
                        });
                    </script>
                </div>
            </div>
        </div>
    </div>
</div>
{{-- STU_CHART --}}
<div class="col-lg-12 mb-2 order-0">
    <div class="card">
        <div class="d-flex align-items-end row">
            <div class="col-sm-12">
                <div class="card-body">
                    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.5.0/Chart.min.js"></script>
                    <canvas id="myChart" style="width:100%;max-width:100%"></canvas>

                    <script type="text/javascript">
                        var data = {!! $STUDENTCLASSESARRAY !!}
                        var xValues = data.class_name
                        var yValues =  data.students_total
                        var barColors = ["#004274", "#004274","#004274","#004274","#004274","#004274", "#004274","#004274","#004274","#004274"];
                        
                           new Chart("myChart", {
                            type: "bar",
                            data: {
                                labels: xValues,
                                datasets: [{
                                    backgroundColor: "#004274",
                                    data: yValues
                                }]
                            },
                            options: {
                                legend: {display: false},
                                title: {
                                    display: true,
                                    text: "Number Of Student"
                                }
                            }
                        });
                    </script>
                </div>
            </div>
        </div>
    </div>
</div>
