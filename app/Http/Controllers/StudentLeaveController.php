<?php

namespace App\Http\Controllers;

use App\Models\Admission;
use App\Models\Staff;
use App\Models\Student;
use App\Models\StudentLeave;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class StudentLeaveController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:student-leave-list|student-leave-create|student-leave-edit|student-leave-delete', ['only' => ['index','store']]);
        $this->middleware('permission:student-leave-create', ['only' => ['create','store']]);
        $this->middleware('permission:student-leave-edit', ['only' => ['edit','update']]);
        $this->middleware('permission:student-leave-delete', ['only' => ['destroy']]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if ( auth()->user()->is_student ){
            $data = StudentLeave::join('students', 'students.id', '=', 'student_leaves.student_id')
                ->join('admissions', 'admissions.id', '=', 'students.admission_id')
                ->select('student_leaves.*')
                ->where('student_auth_id', auth()->user()->id)->orderBy('student_leaves.id', 'DESC')->get();
            return view('student-leaves.index', compact('data'));
        }

        if ( auth()->user()->is_teacher ){
            $data = array();
            $staff = Staff::where('email',auth()->user()->email)->first();
            $SUBID = DB::table('subject_staff')
                ->join('subjects', 'subjects.id', '=', 'subject_staff.subject_id')
                ->where('staff_id', $staff->id)->distinct()->get(['__class_id']);
            foreach ($SUBID as $sub){
                $students = Student::where('__class_id', $sub->__class_id)->get();
                foreach ($students as $student){
                    $std_atds = StudentLeave::where('student_id', $student->id)->latest()->get();
                    foreach ($std_atds as $st){
                        array_push($data, $st);
                    }
                }
            }
            return view('student-leaves.index', compact('data'));
        }
        $data = StudentLeave::latest()->get();
        return view('student-leaves.index', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('student-leaves.create');
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
//                'student_id' => 'required',
                'start_date' => 'required',
                'end_date' => 'required',
                'reason' => 'required',
            ]);

            $studentID = $request->student_id;

            if (auth()->user()->is_student){
                $ad = Admission::where('student_auth_id', auth()->user()->id)->first();
                $st = Student::where('admission_id', $ad->id)->first();
                $studentID = $st->id;
            }

            StudentLeave::create([
                'student_id' => $studentID,
                'start_date' => $request->start_date,
                'end_date' => $request->end_date,
                'reason' => $request->reason,
            ]);

            DB::commit();
            return redirect()->route('student-leaves.index')
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
        $sl = StudentLeave::findOrFail($id);
        return view('student-leaves.show', compact('sl'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data = StudentLeave::findOrFail($id);
        return view('student-leaves.edit', compact('data'));
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
                'student_id' => 'required',
                'start_date' => 'required',
                'end_date' => 'required',
                'reason' => 'required',
                'status' => 'required',
            ]);

            StudentLeave::where('id', $id)->update([
                'student_id' => $request->student_id,
                'start_date' => $request->start_date,
                'end_date' => $request->end_date,
                'reason' => $request->reason,
                'status' => $request->status,
            ]);

            DB::commit();
            return redirect()->route('student-leaves.index')
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
            StudentLeave::where('id', $id)->delete();
            DB::commit();
            return redirect()->route('student-leaves.index')
                ->with('success','Leave deleted successfully');
        }
        catch (\Exception $exception){
            DB::rollBack();
            return redirect()->back()
                ->with('error',$exception->getMessage());
        }
    }
}
