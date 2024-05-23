<?php

namespace App\Http\Controllers;

use App\Models\_Class;
use App\Models\Admission;
use App\Models\Staff;
use App\Models\Student;
use App\Models\StudyMaterial;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class StudyMaterialController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:study-material-list|study-material-create|study-material-edit|study-material-delete', ['only' => ['index','store']]);
        $this->middleware('permission:study-material-create', ['only' => ['create','store']]);
        $this->middleware('permission:study-material-edit', ['only' => ['edit','update']]);
        $this->middleware('permission:study-material-delete', ['only' => ['destroy']]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if ( auth()->user()->is_student ){
            $ad = Admission::where('student_auth_id', auth()->user()->id)->first();
            $st = Student::where('admission_id', $ad->id)->first();
            $data = StudyMaterial::where('class_id', $st->__class_id)->latest()->get();
            return view('study-materials.index', compact('data'));
        }

        if ( auth()->user()->is_teacher ){
            $data = array();
            $staff = Staff::where('email',auth()->user()->email)->first();
            $SUBID = DB::table('subject_staff')
                ->join('subjects', 'subjects.id', '=', 'subject_staff.subject_id')
                ->where('staff_id', $staff->id)->distinct()->get(['__class_id']);
            foreach ($SUBID as $sub){
                $sm = StudyMaterial::where('class_id', $sub->__class_id)->latest()->get();
                foreach ($sm as $s){
                    array_push($data, $s);
                }
            }
            return view('study-materials.index', compact('data'));
        }
        $data = StudyMaterial::latest()->get();
        return view('study-materials.index', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
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
            return view('study-materials.create', compact('classes'));
        }
        $classes = _Class::latest()->get();
        return view('study-materials.create', compact('classes'));
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
                'class_id' => 'required',
                'upload' => 'nullable',
                'text' => 'nullable',
            ]);
            $img = null;
            if($request->upload != '' ){
                $img = time().'.' . $request->upload->getClientOriginalExtension();
                \Image::make($request->upload)->save(public_path('uploads/study/').$img);
            }
            StudyMaterial::create([
                'class_id' => $request->class_id,
                'user_id' => auth()->user()->id,
                'upload' => $img,
                'text' => $request->text,
            ]);
            DB::commit();
            return redirect()->route('study-materials.index')
                ->with('success','Study Material saved successfully');
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
        $c = _CLass::findOrFail($id);
        $sm = StudyMaterial::findOrFail($id);
        return view('study-materials.show',compact('c','sm'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
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
            $data = StudyMaterial::findOrFail($id);
            return view('study-materials.edit', compact('classes', 'data'));
        }
        $classes = _CLass::latest()->get();
        $data = StudyMaterial::findOrFail($id);
        return view('study-materials.edit', compact('classes', 'data'));
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
                'class_id' => 'required',
                'upload' => 'nullable',
                'text' => 'nullable',
            ]);
            $img = null;
            if($request->upload != '' ){
                $img = time().'.' . $request->upload->getClientOriginalExtension();
                \Image::make($request->upload)->save(public_path('uploads/study/').$img);
            }
            $std = StudyMaterial::findOrFail($id);
            $std->class_id = $request->class_id;
            $std->user_id = auth()->user()->id;
            $std->upload = $img === null ? $std->upload : $img;
            $std->text = $request->text;
            $std->update();

            DB::commit();
            return redirect()->route('study-materials.index')
                ->with('success','Study Material saved successfully');
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
            StudyMaterial::where('id', $id)->delete();
            DB::commit();
            return redirect()->route('study-materials.index')
                ->with('success','Study Material deleted successfully');
        }
        catch (\Exception $exception){
            DB::rollBack();
            return redirect()->back()
                ->with('error',$exception->getMessage());
        }
    }
}
