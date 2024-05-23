<?php

namespace App\Http\Controllers;

use App\Models\Staff;
use App\Models\StaffLeave;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class StaffLeaveController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:staff-leave-list|staff-leave-create|staff-leave-edit|staff-leave-delete', ['only' => ['index','store']]);
        $this->middleware('permission:staff-leave-create', ['only' => ['create','store']]);
        $this->middleware('permission:staff-leave-edit', ['only' => ['edit','update']]);
        $this->middleware('permission:staff-leave-delete', ['only' => ['destroy']]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if ( auth()->user()->is_teacher ){
            $staff = Staff::where('email',auth()->user()->email)->first();
            $data = $staff->leaves;//StaffLeave::where('staff_id', )->latest()->get();
            return view('staff-leaves.index', compact('data'));
        }
        $data = StaffLeave::latest()->get();
        return view('staff-leaves.index', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('staff-leaves.create');
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
//                'staff_id' => 'required',
                'start_date' => 'required',
                'end_date' => 'required',
                'reason' => 'required',
            ]);

            $staffID = $request->staff_id;

            if (auth()->user()->is_teacher){
                $staff = Staff::where('email',auth()->user()->email)->first();
                $staffID = $staff->id;
            }

            StaffLeave::create([
                'staff_id' => $staffID,
                'start_date' => $request->start_date,
                'end_date' => $request->end_date,
                'reason' => $request->reason,
            ]);

            DB::commit();
            return redirect()->route('staff-leaves.index')
                ->with('success','Leave saved successfully');
        }
        catch (\Exception $exception){
            DB::rollBack();
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
        $data = StaffLeave::findOrFail($id);
        return view('staff-leaves.show', compact('data'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data = StaffLeave::findOrFail($id);
        return view('staff-leaves.edit', compact('data'));
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
            $request->validate([
                'staff_id' => 'required',
                'start_date' => 'required',
                'end_date' => 'required',
                'reason' => 'required',
                'status' => 'required',
            ]);

            StaffLeave::where('id', $id)->update([
                'staff_id' => $request->staff_id,
                'start_date' => $request->start_date,
                'end_date' => $request->end_date,
                'reason' => $request->reason,
                'status' => $request->status,
            ]);

            DB::commit();
            return redirect()->route('staff-leaves.index')
                ->with('success','Leave updated successfully');
        }
        catch (\Exception $exception){
            DB::rollBack();
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
            StaffLeave::where('id', $id)->delete();
            DB::commit();
            return redirect()->route('staff-leaves.index')
                ->with('success','Leave deleted successfully');
        }
        catch (\Exception $exception){
            DB::rollBack();
            return redirect()->back()
                ->with('error',$exception->getMessage());
        }
    }
}
