<?php

namespace App\Http\Controllers;

use App\Models\_Class;
use App\Models\_Session;
use App\Models\PromotedOrDemoted;
use App\Models\Result;
use App\Models\Staff;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PromotedOrDemotedController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:promote-list|promote-create|promote-edit|promote-delete', ['only' => ['index', 'store']]);
        $this->middleware('permission:promote-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:promote-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:promote-delete', ['only' => ['destroy']]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if ( auth()->user()->is_teacher ){
            $data = array();
            $staff = Staff::where('email',auth()->user()->email)->first();
            $SUBID = DB::table('subject_staff')
                ->join('subjects', 'subjects.id', '=', 'subject_staff.subject_id')
                ->where('staff_id', $staff->id)->distinct()->get(['__class_id']);
            foreach ($SUBID as $sub){
                $students = Student::where('__class_id', $sub->__class_id)->get();
                foreach ($students as $student){
                    $dd = PromotedOrDemoted::join('students', 'students.id', '=', 'promoted_or_demoteds.student_id')
                        ->join('__classes', '__classes.id', '=', 'students.__class_id')
                        ->join('sections', 'sections.id', '=', '__classes.section_id')
                        ->select('promoted_or_demoteds.*', 'students.name as name', 'students.roll_no as roll_no',
                            '__classes.name as class_name', 'sections.name as section_name')
                        ->where('students.id', $student->id)->get();
                    foreach ($dd as $d){
                        array_push($data, $d);
                    }
                }
            }
            return view('promotes.index', compact('data'));
        }
        $data = PromotedOrDemoted::join('students', 'students.id', '=', 'promoted_or_demoteds.student_id')
            ->join('__classes', '__classes.id', '=', 'students.__class_id')
            ->join('sections', 'sections.id', '=', '__classes.section_id')
            ->select('promoted_or_demoteds.*', 'students.name as name', 'students.roll_no as roll_no', '__classes.name as class_name', 'sections.name as section_name')->get();
        return view('promotes.index', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function getStudents($id)
    {
        $SEESIONID = _Session::where('status', 1)->first();
        return Student::with('_class.section')
            ->where('__class_id', $id)
            ->where('__session_id', $SEESIONID->id)->get();
    }

    public function create()
    {
        if ( auth()->user()->is_teacher ){
            $classes = array();
            $staff = Staff::where('email',auth()->user()->email)->first();
            $SUBID = DB::table('subject_staff')
                ->join('subjects', 'subjects.id', '=', 'subject_staff.subject_id')
                ->where('staff_id', $staff->id)->distinct()->get(['__class_id']);
            foreach ($SUBID as $sub){
                $c = _Class::find($sub->__class_id);
                array_push($classes, $c);
            }
            return view('promotes.create', compact('classes'));
        }
        $classes = _Class::all();
        return view('promotes.create', compact('classes'));
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
            foreach ($request->local_students as $student){
                PromotedOrDemoted::create([
                    'student_id' => $student['student']['id'],
                    'promoted_or_demoted' => $student['promoted']
                ]);
            }
            DB::commit();
            return response()->json(['status' => true, 'msg' => 'Record submitted....']);
        }
        catch (\Exception $exception){
            DB::rollBack();
            return response()->json(['status' => false, 'msg' => $exception]);
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
        $data = PromotedOrDemoted::join('students', 'students.id', '=', 'promoted_or_demoteds.student_id')
            ->join('__classes', '__classes.id', '=', 'students.__class_id')
            ->join('sections', 'sections.id', '=', '__classes.section_id')
            ->join('admissions', 'admissions.id', '=', 'students.admission_id')
            ->select('promoted_or_demoteds.*', 'students.name as name', 'students.roll_no as roll_no', 'admissions.gender as gender',
                '__classes.name as class_name', 'sections.name as section_name', 'students.admission_id as admission_id', 'admissions.student_pic as id_proof')
            ->where('promoted_or_demoteds.id', $id)->first();
        $results = Result::where('admission_id', $data->admission_id)->get();
        return view('promotes.show', compact('data', 'results'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data = PromotedOrDemoted::join('students', 'students.id', '=', 'promoted_or_demoteds.student_id')
            ->join('__classes', '__classes.id', '=', 'students.__class_id')
            ->join('sections', 'sections.id', '=', '__classes.section_id')
            ->join('admissions', 'admissions.id', '=', 'students.admission_id')
            ->select('promoted_or_demoteds.*', 'students.name as name', 'students.roll_no as roll_no', 'admissions.gender as gender',
                '__classes.name as class_name', 'sections.name as section_name', 'students.admission_id as admission_id', 'admissions.student_pic as id_proof')
            ->where('promoted_or_demoteds.id', $id)->first();
        $results = Result::where('admission_id', $data->admission_id)->get();
        $classes = _Class::all();
        return view('promotes.edit', compact('results', 'data', 'classes'));
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
            $request->validate([ 'status' => 'required', 'class_id' => 'required' ]);

            $pd = PromotedOrDemoted::findOrFail($id);

            if ($pd->status === $request->status){
                DB::commit();
                return redirect()->back()->with('error', 'ALready exists.......');
            }
            elseif ($pd->status === 'approved' && $request->status === 'pending'){
                DB::commit();
                return redirect()->back()->with('error', 'ALready approved.......');
            }

            if($request->status === 'approved'){
                $SESSIONID = _Session::where('status', 1)->first();
                $pre_std = Student::findOrFail($pd->student_id);

                if ($pre_std->__class_id === $request->class_id){
                    DB::commit();
                    return redirect()->back()->with('error', 'ALready in this class.......');
                }

                if ($pre_std->__session_id === $SESSIONID->id){
                    DB::commit();
                    return redirect()->back()->with('error', 'ALready in this session.......');
                }

                Student::create([
                    'admission_id' => $pre_std->admission_id,
                    '__class_id' => $request->class_id,
                    '__session_id' => $SESSIONID->id,
                    'roll_no' => $pre_std->roll_no,
                    'name' => $pre_std->name,
                ]);
            }

            $pd->status = $request->status;
            $pd->update();

            DB::commit();
            return redirect()->route('promotes.index')
                ->with('success', 'Record updated.....');
        }
        catch (\Exception $exception){
            DB::rollBack();
            return redirect()->back()->with('error', $exception->getMessage());
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
            PromotedOrDemoted::where('id', $id)->delete();
            DB::commit();
            return redirect()->route('promotes.index')
                ->with('success', 'Record updated.....');
        }
        catch (\Exception $exception){
            DB::rollBack();
            return redirect()->back()->with('error', $exception->getMessage());
        }
    }
}
