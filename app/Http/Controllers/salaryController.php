<?php

namespace App\Http\Controllers;

use App\Models\Salary;
use App\Models\Staff;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class salaryController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:salary-list|salary-create|salary-edit|salary-delete', ['only' => ['index','store']]);
        $this->middleware('permission:salary-create', ['only' => ['create','store']]);
        $this->middleware('permission:salary-edit', ['only' => ['edit','update']]);
        $this->middleware('permission:salary-delete', ['only' => ['destroy']]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(auth()->user()->is_teacher){
            $staff = Staff::where('email', auth()->user()->email)->first();
            $data = $staff->salaries;
            return view('salary.index', compact('data'));
        }
        $data = Salary::latest()->get();
        return view('salary.index', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $staffs = Staff::latest()->get();
        return view('salary.create', compact('staffs'));
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
//            VALIDITION
            $request->validate([
                "staff_id" => "required",
                "salary" => "required",
                "deduction_days" => "nullable",
                "deduction" => "nullable",
                "month_of" => "required",
                "note" => "nullable",
            ]);

            $month_of = Carbon::parse($request->month_of)->format('M-Y');
            //            check
            $check = salary::where('staff_id',$request->staff_id)->where('month_of',$month_of)->first();
            if($check !== null){
                return redirect()->back()->with('error','record already exist');
            }

            //            save
            salary::create([
                "staff_id" => $request->staff_id,
                "salary" => $request->salary,
                "deduction_days" => $request->deduction_days,
                "deduction" => $request->deduction,
                "month_of" => $month_of,
                'note' => $request->note,
            ]);

            //            commit
            DB::commit();
            return redirect()->route('salaries.index')
                ->with('success','Salary Saved');
        }catch(\Exception $exception){
            DB::rollback();
            return redirect()->back()
                ->with('error',$exception->getMessage());
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
        $data = Salary::findOrFail($id);
        return view('salary.show', compact('data'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data = Salary::findOrFail($id);
        $staffs = Staff::latest()->get();
        return view('salary.edit', compact('staffs', 'data'));
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
//            VALIDITION
            $request->validate([
                "salary" => "required",
                "deduction_days" => "nullable",
                "deduction" => "nullable",
                "note" => "nullable",
                "status" => "required",
            ]);

            //            save
            salary::where('id', $id)->update([
                "salary" => $request->salary,
                "deduction_days" => $request->deduction_days,
                "deduction" => $request->deduction,
                'note' => $request->note,
                'status' => $request->status,
            ]);

            //            commit
            DB::commit();
            return redirect()->route('salaries.index')
                ->with('success','Salary updated');
        }catch(\Exception $exception){
            DB::rollback();
            return redirect()->back()
                ->with('error',$exception->getMessage());
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
            Salary::find($id)->delete();
            DB::commit();
            return redirect()->route('salaries.index')
                ->with('success','Staff Salary deleted successfully');
        }
        catch (\Exception $exception){
            DB::rollBack();
            return redirect()->back()
                ->with('error',$exception->getMessage());
        }
    }
}
