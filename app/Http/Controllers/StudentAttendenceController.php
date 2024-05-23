<?php

namespace App\Http\Controllers;

use App\Models\_Class;
use App\Models\Staff;
use App\Models\StaffAttendence;
use App\Models\Student;
use App\Models\StudentAttendence;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class StudentAttendenceController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:s_att-list|s_att-create|s_att-edit|s_att-delete', ['only' => ['index','store']]);
        $this->middleware('permission:s_att-create', ['only' => ['create','store']]);
        $this->middleware('permission:s_att-edit', ['only' => ['edit','update']]);
        $this->middleware('permission:s_att-delete', ['only' => ['destroy']]);
        $this->middleware('permission:s_att-list', ['only' => ['listView']]);
    }

    public function update(Request $request, $id)
    {
        DB::beginTransaction();
        try {
            $data = StudentAttendence::findOrFail($id);
            $data->attendence = $request->attendence;
            $data->update();

            DB::commit();
            return redirect()->route('s_atd.list')
                ->with( 'success', 'Record updated.....' );
        }
        catch (\Exception $exception){
            DB::rollBack();
            return redirect()->back()->with('error',$exception->getMessage());
        }
    }

    public function edit($id)
    {
        $data = StudentAttendence::findOrFail($id);
        return view('student-atd.edit', compact('data'));
    }

    public function listView()
    {
        if (auth()->user()->is_student){
            $data = StudentAttendence::join('admissions', 'admissions.id', '=', 'student_attendences.admission_id')
                ->where('admissions.student_auth_id', auth()->user()->id)
                ->select('student_attendences.*')
                ->orderBy('student_attendences.id', 'DESC')->get();
            return view('student-atd.list', compact('data'));
        }

        if(auth()->user()->is_teacher){
            $data = array();
            $staff = Staff::where('email',auth()->user()->email)->first();
            $SUBID = DB::table('subject_staff')
                ->join('subjects', 'subjects.id', '=', 'subject_staff.subject_id')
                ->where('staff_id', $staff->id)->distinct()->get(['__class_id']);
            foreach ($SUBID as $sub){
                $STDATD = StudentAttendence::where('__class_id',$sub->__class_id)->latest()->get();
                foreach ($STDATD as $std){
                    array_push($data, $std);
                }
            }
            return view('student-atd.list', compact('data'));
        }
        $data = StudentAttendence::latest()->get();
        return view('student-atd.list', compact('data'));
    }

    public function create()
    {
        if(auth()->user()->is_teacher){
            $class = array();
            $staff = Staff::where('email',auth()->user()->email)->first();
            $SUBID = DB::table('subject_staff')
                ->join('subjects', 'subjects.id', '=', 'subject_staff.subject_id')
                ->where('staff_id', $staff->id)->distinct()->get(['__class_id']);
            foreach ($SUBID as $sub){
                $c = _Class::find($sub->__class_id);
                array_push($class, $c);
            }
            return view('student-atd.index', compact('class'));
        }
        $class = _Class::all();
        return view('student-atd.index', compact('class'));
    }

    public function store(Request $request)
    {
        try {
            foreach ($request->data as $d){

                $student = Student::findOrFail( $d['id'] );

                $chk = StudentAttendence::where('__class_id', $student->_class->id)->where('student_id', $student->id)
                        ->where('added_at', $d['date'])->first();

                if ($chk !== null){
                    $chk->attendence = $d['status'];
                    $chk->update();

                }
                else{
                    StudentAttendence::create([
                        'admission_id' => $student->admission->id,
                        '__class_id' => $student->_class->id,
                        '__session_id' => $student->__session_id,
                        'student_id' => $student->id,
                        'attendence' => $d['status'],
                        'added_at' => $d['date']
                    ]);
                }
            }

            return response()->json([ 'status' => true, 'msg' => 'Attendance marked' ]);
        }
        catch (\Exception $exception){
            return response()->json([ 'status' => false, 'msg' => $exception->getMessage() ]);
        }
        dd($request);
    }

    public function getStudentsFromClass($id)
    {
        return Student::where('__class_id', $id)->where('status', 'active')->get();
    }

    public function index()
    {

    }
}
