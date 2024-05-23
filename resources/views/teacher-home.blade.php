{{-- //TOTAL STUDENT --}}
<div class="col-lg-12">
    @include('partials.notice')
</div>

<div class="col-lg-3 mb-2 order-0">
    <div class="card bg-light">
        <div class="card-body">
            <h5 class="card-title">Total Student</h5>
            <p class="card-text display-5">{{ count($data1) }}</p>
        </div>
    </div>
</div>


{{-- //CLASSES --}}
<div class="col-lg-3 mb-2 order-0">
    <div class="card bg-light">
        <div class="card-body">
            <h5 class="card-title">Total Classes</h5>
            <p class="card-text display-5">{{ count($SUBID) }}</p>
        </div>
    </div>

</div>
{{-- //TOTAL ASSIGN SUBJECTS --}}
<div class="col-lg-3 mb-2 order-0">
    <div class="card bg-light">
        <div class="card-body">
            <h5 class="card-title">Total Assign Subjects</h5>
            <p class="card-text display-5">{{ count($SUB) }}</p>
        </div>
    </div>
</div>
{{-- //SALARY --}}
<div class="col-lg-3 mb-2 order-0">
    <div class="card bg-light">
        <div class="card-body">
            <h5 class="card-title">Collected Salary</h5>
            <p class="card-text display-5">{{ $totalSalary }}</p>
        </div>
    </div>
</div>
{{-- //CHART --}}
<div class="col-lg-6 mb-2 order-0">
    <div class="card">
        <div class="d-flex align-items-end row">
            <div class="col-sm-12">
                <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.js"></script>
                <canvas id="abc" style="width:40%;height:90%;max-width:100%"></canvas>
                <script>
                    var xValues = ["Absent", "Present", "Leaves", "Late"];
                    var yValues = [{{ $absent }}, {{ $present }}, {{ $leave }}, {{ $late }}];
                    var barColors = [
                        "#b91d47",
                        "#00aba9",
                        "#2b5797",
                        "#CB3414",
                    ];

                    new Chart("abc", {
                        type: "doughnut",
                        data: {
                            labels: xValues,
                            datasets: [{
                                backgroundColor: barColors,
                                data: yValues
                            }]
                        },
                        options: {
                            title: {
                                display: true,
                                text: "Your Presence Status"
                            }
                        }
                    });
                </script>
            </div>
        </div>
    </div>
</div>
{{-- salary chart --}}
<div class="col-lg-6 mb-2 order-0">
    <div class="card">
        <div class="d-flex align-items-end row">
            <div class="col-sm-12">
                <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.js"></script>
                <canvas id="chart" style="width:40%;height:90%;max-width:100%"></canvas>
                <script>
                    var XValues = ["Salary", "Deduction"];
                    var YValues = [{{ $salary->salary ?? 0 }}, {{ $salary->deduction ?? 0 }}];
                    var BarColors = [
                        "#b91d47",
                        "#00aba9",
                    ];

                    new Chart("chart", {
                        type: "pie",
                        data: {
                            labels: XValues,
                            datasets: [{
                                backgroundColor: BarColors,
                                data: YValues
                            }]
                        },
                        options: {
                            title: {
                                display: true,
                                text: "Salary of {{ $salary->month_of ?? date('M') }}"
                            }
                        }
                    });
                </script>
            </div>
        </div>
    </div>
</div>
