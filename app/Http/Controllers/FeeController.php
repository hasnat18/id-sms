<?php

namespace App\Http\Controllers;

use App\Models\_Session;
use App\Models\Admission;
use App\Models\FeeDetails;
use App\Models\Fees;
use App\Models\_Class;
use App\Models\Student;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class FeeController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:fee-list|fee-create|fee-edit|fee-delete', ['only' => ['index','store']]);
        $this->middleware('permission:fee-create', ['only' => ['create','store']]);
        $this->middleware('permission:fee-edit', ['only' => ['edit','update']]);
        $this->middleware('permission:fee-delete', ['only' => ['destroy']]);
    }

    public function printViewByIDS($ids)
    {
        $get_ids = json_decode($ids);
        $fees = array();
        foreach ($get_ids as $id){
            array_push( $fees, Fees::findOrFail($id) );
        }
        return view('fees.printGetByIDS', compact('fees'));
    }

    public function printViewAll()
    {
        $fees = Fees::where('status', 'pending')->get();
        return view('fees.printAll', compact('fees'));
    }

    public function printViewSingleID($id)
    {
        $fee = Fees::findOrFail($id);
        return view('fees.print', compact('fee'));
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index()
    {
        if (auth()->user()->is_student){
            $data = Fees::where('user_id', auth()->user()->id )->latest()->get();
            return view('fees.index', compact('data'));
        }
        $data = Fees::latest()->get();
        return view('fees.index', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
      public function create()
    {
        $_classes = _Class::latest()->get();
       
        return view('fees.create', compact('_classes'));
    }
public function getStudents(Request $request)
{
 
    $students = Admission::with('student')->where('__class_id',  $request->classId)->get();
    return response()->json($students);
}

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        DB::beginTransaction();
        try {
            $request->validate([
                "admission_id" => "required",
                "month_of" => "required",
                "due_date" => "required",
            ]);

            $feeArr = json_decode($request->feeArr);
            $amount = 0;
            foreach ($feeArr as $f){
                $amount += $f->amount;
            }

            $get_admission = Admission::findOrFail($request->admission_id);
            $get_session = _Session::where('status', 1)->first();

            $chk_month = Carbon::now()->format('M-Y');
            $chk = Fees::where('admission_id', $request->admission_id)
                ->where('__session_id', $get_session->id)->where('month_of', $chk_month)->first();

            if($chk !== null){
                DB::commit();
                return redirect()->back()->with('error', 'This fee is already created.');
            }

            $pendings = Fees::where('admission_id', $request->admission_id)->where('status', 'pending')->get();
            $arrears = 0;
            foreach ($pendings as $p){
                $arrears += $p->total;
            }

            $userID = $get_admission->student_auth_id !== null ? $get_admission->student_auth_id : 0;

            $fee = Fees::create([
                'admission_id' => $request->admission_id,
                '__class_id'=> $request->class_id,
                '__session_id' => $get_session->id,
                'student_id' => $get_admission->student->id,
                'user_id' => $userID,
                'month_of' => Carbon::parse($request->month_of)->format('M-Y'),
                'due_date' => $request->due_date,
                'total' => $amount + $arrears,
                'arrears' => $arrears
            ]);

            foreach ($feeArr as $f){
                FeeDetails::create([
                    'fee_id' => $fee->id,
                    'fee_type' => $f->type,
                    'fee_amount' => $f->amount,
                ]);
            }

            DB::commit();
            return response()->json([ 'status' => true, 'msg' => 'Record created.....' ]);
        }
        catch (\Exception $exception){
            DB::rollBack();
            return response()->json([ 'status' => false, 'msg' => $exception->getMessage() ]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $f = Fees::findOrFail($id);
        $fds = FeeDetails::where('fee_id',$id)->get();
//        $r = Result::findOrFail($id);
//        $rds = ResultDetail::where('result_id', $id)->get();
//        dd($data1);
        return view('fees.show', compact('f','fds'));
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data = Fees::findOrFail($id);
        return view('fees.edit', compact('data'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        DB::beginTransaction();
        try {
            $fee = Fees::findOrFail($id);
            $fee->paid_at = date('Y-m-d');
            $fee->status = 'paid';
            $fee->update();

            DB::commit();
            return redirect()->route('fees.index')
                ->with( 'success', 'Record updated.....' );
        }
        catch (\Exception $exception){
            DB::rollBack();
            return redirect()->back()->with('error',$exception->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        DB::beginTransaction();
        try {
            Fees::where('id', $id)->delete();

            DB::commit();
            return redirect()->route('fees.index')
                ->with( 'success', 'Record deleted.....' );
        }
        catch (\Exception $exception){
            DB::rollBack();
            return redirect()->back()->with('error',$exception->getMessage());
        }
    }
}
