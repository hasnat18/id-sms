<style>
    .btn {
        display: inline-block;
        text-align: center;
        vertical-align: middle;
        user-select: none;
        background-color: transparent;
        border: 1px solid transparent;
        padding: 0.375rem 0.75rem;
        font-size: .875rem;
        line-height: 1.5;
        border-radius: 0.25rem;
        transition: color .15s ease-in-out, background-color .15s ease-in-out, border-color .15s ease-in-out, box-shadow .15s ease-in-out;
    }
    .btn-primary {
        background-color: #fb9678;
        border-color: #fb9678;
        color: white;
    }
    body{
        background-color: darkgray;
    }
    @media print {
        @page  { margin: 32px auto; }
        body { margin: 1.6cm }
    }
</style>

<div style="margin: 20px 0">
    <button class="btn btn-primary" onclick="printAll()">Print</button>
</div>

<div id="A4">
    @foreach($fees as $fee)
        <div style=" width: 297mm;
            min-height: 200mm;
            margin: 0 auto;
            background: white;
            padding: 5px">
            <table style="width: 100%">
                <tbody>
                <tr>
                    <td style="width: 33%;padding-right: 10px; ">
                        <div style="border: 1px solid gray; padding: 5px 10px;">
                            <div style="display: flex; justify-content: space-around">
                                <p style="text-align: left">Bank Al-Habib <br> Shahrah-e-Faisal Branch <br> Karachi</p>
                                <p style="text-align: right">Due Date <br> {{ \Carbon\Carbon::parse( $fee->due_date )->format('d.m.Y')  }} <br> BANK COPY</p>
                            </div>
                            <p style="font-weight: bold">A/c. 1003-0072-54478-75-1</p>
                            <p>Challan No: <span style="border: 1px solid gray; padding: 5px 10px; background-color: lightgray">{{ $fee->id }}</span></p>
                            <p>GR. No: <span>{{ $fee->admission->gr_no }}</span></p>
                            <p>Issue Date: <span>{{ \Carbon\Carbon::now()->format('M d, Y') }}</span></p>
                        </div>
                        <div STYLE="text-align: center">
                            <p style="font-weight: bold">Custom Public School <br> Gulshan-e-Iqbal, Block-11</p>
                        </div>
                        <div style="text-align: left">
                            <p>Student's Name: {{ $fee->admission->student_name }}</p>
                            <p>Class: {{ $fee->students->_class->name.' - '.$fee->students->_class->section->name }}</p>
                        </div>
                        <table border="1" style="">
                            <thead>
                            <td style="width: 80%; padding: 5px 10px;border-style: none;">FEES</td>
                            <td style="width: 20%; padding: 5px 10px;border-style: none;">AMOUNT</td>
                            </thead>
                            <tbody>
                            @foreach($fee->feedetails as $fd)
                                <tr>
                                    <td style="width: 80%; padding: 5px 10px;border-style: none; font-size: 12px">{{ strtoupper($fd->fee_type) }}</td>
                                    <td style="width: 20%; padding: 5px 10px;border-style: none; font-size: 12px">{{ strtoupper($fd->fee_amount) }}</td>
                                </tr>
                            @endforeach
                            <tr>
                                <td style="width: 80%; padding: 5px 10px;border-style: none; font-size: 12px">Arrears</td>
                                <td style="width: 20%; padding: 5px 10px;border-style: none; font-size: 12px">{{ $fee->arrears }}</td>
                            </tr>
                            </tbody>
                        </table>
                        <table>
                            <tr>
                                <td style="width: 80%; padding: 5px 10px;font-size: 10px;">
                                    TOTAL PAYMENT BY DUE DATE
                                </td>
                                <td style="width: 20%; padding: 5px 10px;font-size: 10px"> RS. {{ $fee->total }}</td>
                            </tr>
                            <tr>
                                <td style="width: 80%; padding: 5px 10px;font-size: 10px;">
                                    Surcharge
                                </td>
                                <td style="width: 20%; padding: 5px 10px;font-size: 10px"> RS. 100</td>
                            </tr>
                            <tr>
                                <td style="width: 80%; padding: 5px 10px;font-size: 10px;">
                                    TOTAL PAYMENT AFTER DUE DATE
                                </td>
                                <td style="width: 20%; padding: 5px 10px;font-size: 10px"> RS. {{ $fee->total + 100 }}</td>
                            </tr>
                        </table>
                        <div style="text-align: center;padding: 20px;border: 1px solid;">
                            Bank Stamp
                        </div>
                    </td>
                    <td style="width: 33%;padding-right: 10px; ">
                        <div style="border: 1px solid gray; padding: 5px 10px;">
                            <div style="display: flex; justify-content: space-around">
                                <p style="text-align: left">Bank Al-Habib <br> Shahrah-e-Faisal Branch <br> Karachi</p>
                                <p style="text-align: right">Due Date <br> {{ \Carbon\Carbon::parse( $fee->due_date )->format('d.m.Y')  }} <br> SCHOOL COPY</p>
                            </div>
                            <p style="font-weight: bold">A/c. 1003-0072-54478-75-1</p>
                            <p>Challan No: <span style="border: 1px solid gray; padding: 5px 10px; background-color: lightgray">{{ $fee->id }}</span></p>
                            <p>GR. No: <span>{{ $fee->admission->gr_no }}</span></p>
                            <p>Issue Date: <span>{{ \Carbon\Carbon::now()->format('M d, Y') }}</span></p>
                        </div>
                        <div style="text-align: center">
                            <p style="font-weight: bold">Custom Public School <br> Gulshan-e-Iqbal, Block-11</p>
                        </div>
                        <div style="text-align: left">
                            <p>Student's Name: {{ $fee->admission->student_name }}</p>
                            <p>Class: {{ $fee->students->_class->name.' - '.$fee->students->_class->section->name }}</p>
                        </div>
                        <table border="1" style="">
                            <thead>
                            <td style="width: 80%; padding: 5px 10px;border-style: none;">FEES</td>
                            <td style="width: 20%; padding: 5px 10px;border-style: none;">AMOUNT</td>
                            </thead>
                            <tbody>
                            @foreach($fee->feedetails as $fd)
                                <tr>
                                    <td style="width: 80%; padding: 5px 10px;border-style: none; font-size: 12px">{{ strtoupper($fd->fee_type) }}</td>
                                    <td style="width: 20%; padding: 5px 10px;border-style: none; font-size: 12px">{{ strtoupper($fd->fee_amount) }}</td>
                                </tr>
                            @endforeach
                            <tr>
                                <td style="width: 80%; padding: 5px 10px;border-style: none; font-size: 12px">Arrears</td>
                                <td style="width: 20%; padding: 5px 10px;border-style: none; font-size: 12px">{{ $fee->arrears }}</td>
                            </tr>
                            </tbody>
                        </table>
                        <table>
                            <tr>
                                <td style="width: 80%; padding: 5px 10px;font-size: 10px;">
                                    TOTAL PAYMENT BY DUE DATE
                                </td>
                                <td style="width: 20%; padding: 5px 10px;font-size: 10px"> RS. {{ $fee->total }}</td>
                            </tr>
                            <tr>
                                <td style="width: 80%; padding: 5px 10px;font-size: 10px;">
                                    Surcharge
                                </td>
                                <td style="width: 20%; padding: 5px 10px;font-size: 10px"> RS. 100</td>
                            </tr>
                            <tr>
                                <td style="width: 80%; padding: 5px 10px;font-size: 10px;">
                                    TOTAL PAYMENT AFTER DUE DATE
                                </td>
                                <td style="width: 20%; padding: 5px 10px;font-size: 10px"> RS. {{ $fee->total + 100 }}</td>
                            </tr>
                        </table>
                        <div style="text-align: center;padding: 20px;border: 1px solid;">
                            Bank Stamp
                        </div>
                    </td>
                    <td style="width: 33%">
                        <div style="border: 1px solid gray; padding: 5px 10px;">
                            <div style="display: flex; justify-content: space-around">
                                <p style="text-align: left">Bank Al-Habib <br> Shahrah-e-Faisal Branch <br> Karachi</p>
                                <p style="text-align: right">Due Date <br> {{ \Carbon\Carbon::parse( $fee->due_date )->format('d.m.Y')  }} <br> STUDENT'S COPY</p>
                            </div>
                            <p style="font-weight: bold">A/c. 1003-0072-54478-75-1</p>
                            <p>Challan No: <span style="border: 1px solid gray; padding: 5px 10px; background-color: lightgray">{{ $fee->id }}</span></p>
                            <p>GR. No: <span>{{ $fee->admission->gr_no }}</span></p>
                            <p>Issue Date: <span>{{ \Carbon\Carbon::now()->format('M d, Y') }}</span></p>
                        </div>
                        <div style="text-align: center">
                            <p style="font-weight: bold">Custom Public School <br> Gulshan-e-Iqbal, Block-11</p>
                        </div>
                        <div style="text-align: left">
                            <p>Student's Name: {{ $fee->admission->student_name }}</p>
                            <p>Class: {{ $fee->students->_class->name.' - '.$fee->students->_class->section->name }}</p>
                        </div>
                        <table border="1" style="">
                            <thead>
                            <td style="width: 80%; padding: 5px 10px;border-style: none;">FEES</td>
                            <td style="width: 20%; padding: 5px 10px;border-style: none;">AMOUNT</td>
                            </thead>
                            <tbody>
                            @foreach($fee->feedetails as $fd)
                                <tr>
                                    <td style="width: 80%; padding: 5px 10px;border-style: none; font-size: 12px">{{ strtoupper($fd->fee_type) }}</td>
                                    <td style="width: 20%; padding: 5px 10px;border-style: none; font-size: 12px">{{ strtoupper($fd->fee_amount) }}</td>
                                </tr>
                            @endforeach
                            <tr>
                                <td style="width: 80%; padding: 5px 10px;border-style: none; font-size: 12px">Arrears</td>
                                <td style="width: 20%; padding: 5px 10px;border-style: none; font-size: 12px">{{ $fee->arrears }}</td>
                            </tr>
                            </tbody>
                        </table>
                        <table>
                            <tr>
                                <td style="width: 80%; padding: 5px 10px;font-size: 10px;">
                                    TOTAL PAYMENT BY DUE DATE
                                </td>
                                <td style="width: 20%; padding: 5px 10px;font-size: 10px"> RS. {{ $fee->total }}</td>
                            </tr>
                            <tr>
                                <td style="width: 80%; padding: 5px 10px;font-size: 10px;">
                                    Surcharge
                                </td>
                                <td style="width: 20%; padding: 5px 10px;font-size: 10px"> RS. 100</td>
                            </tr>
                            <tr>
                                <td style="width: 80%; padding: 5px 10px;font-size: 10px;">
                                    TOTAL PAYMENT AFTER DUE DATE
                                </td>
                                <td style="width: 20%; padding: 5px 10px;font-size: 10px"> RS. {{ $fee->total + 100 }}</td>
                            </tr>
                        </table>
                        <div style="text-align: center;padding: 20px;border: 1px solid;">
                            Bank Stamp
                        </div>
                    </td>
                </tr>
                </tbody>
            </table>
        </div>
    @endforeach
</div>

<script>
    function printAll() {
        var restorepage = document.body.innerHTML;
        var printcontent = document.getElementById('A4').innerHTML;
        document.body.innerHTML = printcontent;
        window.print();
        document.body.innerHTML = restorepage;
    }
</script>
