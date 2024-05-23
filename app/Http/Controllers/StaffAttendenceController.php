<?php

namespace App\Http\Controllers;

use App\Models\Staff;
use App\Models\StaffAttendence;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class StaffAttendenceController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:st_atd-list|st_atd-create|st_atd-edit|st_atd-delete', ['only' => ['index','store']]);
        $this->middleware('permission:st_atd-create', ['only' => ['create','store']]);
        $this->middleware('permission:st_atd-edit', ['only' => ['edit','update']]);
        $this->middleware('permission:st_atd-delete', ['only' => ['destroy']]);
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
            $data = $staff->staff_atds;
            return view('staff-atd.index', compact('data'));
        }
        $data = StaffAttendence::latest()->get();
        return view('staff-atd.index', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $staffs = Staff::all();
        return view('staff-atd.create', compact('staffs'));
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
                "time_in" => "nullable",
                "time_out" => "nullable",
                "add_at" => "required",
                "status" => "required",
            ]);
//            check
                $check = StaffAttendence::where('staff_id',$request->staff_id)->where('add_at',$request->add_at)->first();
                if($check !== null){
                    return redirect()->back()->with('error','recourd already exist');
                }
//            save
            StaffAttendence::create([
                "staff_id" => $request->staff_id,
                "time_in" => $request->time_in,
                "time_out" => $request->time_out,
                "add_at" => $request->add_at,
                "status" => $request->status,
                'month_off' => Carbon::parse( $request->add_at )->format('M-Y')
            ]);

//            commit
            DB::commit();
            return redirect()->route('staff-attendance.index')
                ->with('success','Staff Attendance Saved');
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
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $staffs = Staff::all();
        $data = StaffAttendence::findOrFail($id);
//        dd($data);
        return view('staff-atd.edit', compact('data','staffs'));
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
//                "staff_id" => "required",
                "time_in" => "nullable",
                "time_out" => "nullable",
//                "add_at" => "required",
                "status" => "required",
            ]);
//            check
//            $check = StaffAttendence::where('staff_id',$request->staff_id)->where('add_at',$request->add_at)->first();
//            if($check !== null){
//                return redirect()->back()->with('error','recourd already exist');
//            }
//            update

            StaffAttendence::where('id',$id)->update([
//                "staff_id" => $request->staff_id,
                "time_in" => $request->time_in,
                "time_out" => $request->time_out,
//                "add_at" => $request->add_at,
                "status" => $request->status,
            ]);

//            commit
            DB::commit();
            return redirect()->route('staff-attendance.index')
                ->with('success','Staff Attendance Saved');
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
            StaffAttendence::find($id)->delete();
            DB::commit();
            return redirect()->route('staff-attendance.index')
                ->with('success','Staff Attendence deleted successfully');
        }
        catch (\Exception $exception){
            DB::rollBack();
            return redirect()->back()
                ->with('error',$exception->getMessage());
        }
    }
}
