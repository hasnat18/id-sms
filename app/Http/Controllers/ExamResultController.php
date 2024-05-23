<?php

namespace App\Http\Controllers;

use App\Models\{
    _Class,
    _Session,
    Result,
    ResultDetail,
    Staff,
    Student,
    Admission,
    Subject,
    SUBSTAFF
};
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ExamResultController extends Controller
{

    function __construct()
    {
        $this->middleware('permission:result-list|result-create|result-edit|result-delete', ['only' => ['index','store']]);
        $this->middleware('permission:result-create', ['only' => ['create','store']]);
        $this->middleware('permission:result-edit', ['only' => ['edit','update']]);
        $this->middleware('permission:result-delete', ['only' => ['destroy']]);
    }




    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if ( auth()->user()->is_student ){
            $data = Result::join('admissions', 'admissions.id', '=', 'results.admission_id')
                ->where('admissions.student_auth_id', auth()->user()->id)
                ->select('results.*')
                ->orderBy('results.id', 'DESC')->get();
            return view('result.index', compact('data'));
        }

        if ( auth()->user()->is_teacher ){
            $data = array();
            $staff = Staff::where('email', auth()->user()->email)->first();
            $SUBID = DB::table('subject_staff')
                ->join('subjects', 'subjects.id', '=', 'subject_staff.subject_id')
                ->where('staff_id', $staff->id)->distinct()->get(['__class_id']);
            foreach ($SUBID as $sub){
                $rs = Result::where('class_id', $sub->__class_id)->latest()->get();
                foreach ($rs as $r){
                    array_push($data, $r);
                }
            }
            return view('result.index', compact('data'));
        }

        $data = Result::latest()->get();
        return view('result.index', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
       if ( auth()->user()->is_admin ){
           
            $classes = _Class::select("*")->get();
            
            return view('result.create', compact('classes'));
        }
        
        elseif ( auth()->user()->is_teacher ){
            $classes = array();
            $staff = Staff::where('email',auth()->user()->email)->first();
            $SUBID = DB::table('subject_staff')
                ->join('subjects', 'subjects.id', '=', 'subject_staff.subject_id')
                ->where('staff_id', $staff->id)->distinct()->get(['__class_id']);
            foreach ($SUBID as $sub){
                $c = _Class::find($sub->__class_id);
                array_push($classes, $c);
            }
            return view('result.create', compact('classes'));
        }
        $classes = _Class::latest()->get();
        return view('result.create', compact('classes'));
    }
    
    
    public function getStudents(Request $request)
    {
        $subjectStaff = array();
        $students     = array();
        $classId = isset($request->classId) ? $request->classId : '';
        if($classId != '') {
            if ( auth()->user()->is_teacher ){
                
                $staff = Staff::where('email', auth()->user()->email)->first();
                $subjectStaff = SUBSTAFF::where('staff_id', $staff->id)
                                ->with('getSubject')
                                ->whereHas('getSubject._class', function($query) use($classId) {
                                        return $query->where('__class_id', $classId);
                                })
                                ->get();
                    
                $students = Admission::with('student')->where('__class_id',  $request->classId)->get();
                
            }      elseif ( auth()->user()->is_admin ){
                
                $staff = Staff::where('email', auth()->user()->email)->first();
                $subjectStaff = SUBSTAFF::with('getSubject')
                                ->whereHas('getSubject._class', function($query) use($classId) {
                                        return $query->where('__class_id', $classId);
                                })
                                ->get();
                    
                $students = Admission::with('student')->where('__class_id',  $request->classId)->get();
                
            } 
            
            else {
                $subject = Subject::where('__class_id', $request->classId)->get();
                $students = Admission::with('student')->where('__class_id',  $request->classId)->get();
            }
            
            if($subjectStaff != '' && count($subjectStaff) > 0){
                return response()->json([
                    'success' => true,
                    'student' => $students,
                    'subject' => $subjectStaff
                ], 200);
            } else {
                return response()->json([
                    'success' => false,
                    'student' => $students,
                    'subject' => $subjectStaff
                ], 200);
            }
        }
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
            // dd($request['formData']);
            $classId = 0;
            $examType = "";
            $obtMarks = 0;
            for($i = 0; $i <= $request['totalStudent']; $i++){
                foreach($request['formData'] as $key => $val){
                    if ($val['name'] == "class_id") {
                        $classId = $val['value'];
                    }
                    if($val['name'] == "exam_type") {
                        $examType = $val['value'];
                    }
                    if($key > 2 && $val['name'] != "totalStudent" && $val['name'] != "totalSubjects") {
                        $obtMarks = $val['value'];
                    }
                    
                    $result = Result::create([
                        'admission_id' => 0,
                        'student_id' => 0,
                        'class_id' => $classId,
                        'session_id' => 0,
                        'exam_type' => $examType,
                        'total_marks' => 0,
                        'obtained_marks' => $obtMarks,
                        'percentage' => "",
                        'grade' => "",
                        'status' => 1,
                    ]);

                    // foreach ($request->local_subjects as $ls){
                    //     ResultDetail::create([
                    //         'result_id' => $result->id,
                    //         'subject_name' => $ls['subject_name'],
                    //         'subject_marks' => $ls['total_marks'],
                    //         'obtained_marks' => $ls['obt_marks'],
                    //     ]);
                    // }
                    
                }
            }
            
            // $admission = Student::findOrFail($request->formData['student_id']);
             
            // $session = _Session::where('status', 1)->first();

            // $total_marks = 0;
            // $obt_marks = 0;
            // foreach ($request->local_subjects as $ls){
            //     $total_marks += $ls['total_marks'];
            //     $obt_marks += $ls['obt_marks'];
            // }
            // $percentage = ceil($obt_marks/$total_marks*100);
            // $grade = null;
            // $status = null;
            // if ($percentage > 90){ $grade = 'A+'; $status = 'credit';}
            // else if ($percentage > 80 && $percentage < 90){ $grade = 'A'; $status = 'pass'; }
            // else if ($percentage > 70 && $percentage < 80){ $grade = 'B'; $status = 'pass'; }
            // else if ($percentage > 60 && $percentage < 70){ $grade = 'C'; $status = 'pass'; }
            // else if ($percentage > 50 && $percentage < 60){ $grade = 'D'; $status = 'pass'; }
            // else { $grade = 'F'; $status = 'fail'; }

            // $result = Result::create([
            //     'admission_id' => $admission->admission_id,
            //     'student_id' => $admission->id,
            //     'class_id' => $request->formData['class_id'],
            //     'session_id' => $session->id,
            //     'exam_type' => $request->formData['exam_type'],
            //     'total_marks' => $total_marks,
            //     'obtained_marks' => $obt_marks,
            //     'percentage' => $percentage,
            //     'grade' => $grade,
            //     'status' => $status,
            // ]);

            // foreach ($request->local_subjects as $ls){
            //     ResultDetail::create([
            //         'result_id' => $result->id,
            //         'subject_name' => $ls['subject_name'],
            //         'subject_marks' => $ls['total_marks'],
            //         'obtained_marks' => $ls['obt_marks'],
            //     ]);
            // }
            DB::commit();
            return response()->json([ 'status' => true, 'msg' => 'Record saved....' ]);
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
        $data = Result::findOrFail($id);
        $classes = _Class::latest()->get();
        $rds = ResultDetail::where('result_id', $id)->get();
        return view('result.show', compact('classes', 'data', 'rds'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data = Result::findOrFail($id);
        $classes = _Class::latest()->get();
        $rds = ResultDetail::where('result_id', $id)->get();
        return view('result.edit', compact('classes', 'data', 'rds'));
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

            $grade = null;
            $status = null;
            $percentage = ceil($request->formData['per']);
            $total_marks = $request->formData['total'];
            $obt_marks = $request->formData['obt'];

            if ($percentage > 90){ $grade = 'A+'; }
            else if ($percentage > 80 && $percentage < 90){ $grade = 'A'; $status = 'pass'; }
            else if ($percentage > 70 && $percentage < 80){ $grade = 'B'; $status = 'pass'; }
            else if ($percentage > 60 && $percentage < 70){ $grade = 'C'; $status = 'pass'; }
            else if ($percentage > 50 && $percentage < 60){ $grade = 'D'; $status = 'pass'; }
            else { $grade = 'F'; $status = 'fail'; }

            $data = Result::findOrFail($id);
            $data->total_marks = $total_marks;
            $data->obtained_marks = $obt_marks;
            $data->percentage = $percentage;
            $data->grade = $grade;
            $data->status = $status;
            $data->update();

            foreach ($request->local_result_details as $ls){
                $rs = ResultDetail::findOrFail($ls['id']);
                $rs->subject_name = $ls['subject_name'];
                $rs->subject_marks = $ls['total_marks'];
                $rs->obtained_marks = $ls['obt_marks'];
                $rs->update();
            }
            DB::commit();
            return response()->json([ 'status' => true, 'msg' => 'Record saved....' ]);
        }
        catch (\Exception $exception){
            DB::rollBack();
            return response()->json([ 'status' => false, 'msg' => $exception->getMessage() ]);
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
        {
            DB::beginTransaction();
            try {
                ResultDetail:: where('result_id',$id)->delete();
                Result::where('id', $id)->delete();

                DB::commit();
                return redirect()->route('result.index')
                    ->with( 'success', 'Record deleted.....' );
            }
            catch (\Exception $exception){
                DB::rollBack();
                return redirect()->back()->with('error',$exception->getMessage());
            }
        }
    }
}
