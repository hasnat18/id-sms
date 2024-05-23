{{-- Transport --}}
<div class="col-lg-12">
    @include('partials.notice')
</div>

<div class="col-lg-3 mb-2 order-0">
    <div class="card bg-light">
        <div class="card-body">
            <h5 class="card-title">Total Attendended Class</h5>
            <p class="card-text display-5">{{ $d->studentAtd->where('attendence', 'present')->count() }}</p>
        </div>
    </div>
</div>

<div class="col-lg-3 mb-2 order-0">
    <div class="card bg-light">
        <div class="card-body">
            <h5 class="card-title">Total Subjects</h5>
            <p class="card-text display-5">{{ $d->student->_class->subject->count() }}</p>
        </div>
    </div>
</div>

<div class="col-lg-3 mb-2 order-0">
    <div class="card bg-light">
        <div class="card-body">
            <h5 class="card-title">Paid Fee</h5>
            <p class="card-text display-5">{{ $fee->total }}</p>
        </div>
    </div>
</div>

<div class="col-lg-3 mb-2 order-0">
    <div class="card bg-light">
        <div class="card-body">
            <h5 class="card-title">Live Classes</h5>
            @isset($livelink)
                <p class="card-text display-5">{{ $livelink->count() }}</p>
            @else
                <p class="card-text display-5">0</p>
            @endisset
        </div>
    </div>
</div>

{{-- fee chart --}}
<div class="col-lg-12 mb-2 order-0">
    <div class="card">
        <div class="d-flex align-items-end row">
            <div class="col-sm-12">
                <div class="card-body">
                    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.js"></script>
                    <h5 class="card-title" style="color:#004274">Fee Details</h5>
                    <canvas id="myChart" style="width:100%;max-width:100%"></canvas>

                    <script>
                        var fee = {!! $fees !!};
                        var arr = {
                            total: [],
                            month_of: []
                        }


                        for (let i = 0; i < fee.length; i++) {
                            arr.month_of.push(fee[i].month_of);
                            arr.total.push(fee[i].total);
                        }
                        var xValues = (arr.month_of)
                        var yValues = (arr.total)
                        {{-- var yValues = {{$fees->total}}; --}}

                        new Chart("myChart", {
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
                                            min: {{ $minmax->DateStart }},
                                            max: {{ $minmax->DateEnd }}
                                        }
                                    }],
                                }
                            }
                        });
                    </script>
                </div>
            </div>
        </div>
    </div>
</div>
