<?php

namespace App\Http\Controllers;

use App\Models\_Class;
use App\Models\Admission;
use App\Models\LiveClass;
use App\Models\Staff;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class LiveClassController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:live-class-list|live-class-create|live-class-edit|live-class-delete', ['only' => ['index','store']]);
        $this->middleware('permission:live-class-create', ['only' => ['create','store']]);
        $this->middleware('permission:live-class-edit', ['only' => ['edit','update']]);
        $this->middleware('permission:live-class-delete', ['only' => ['destroy']]);
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
            $data = LiveClass::where('class_id', $st->__class_id)->latest()->get();
            return view('live-classes.index', compact('data'));
        }

        if (auth()->user()->is_teacher){
            $data = array();
            $staff = Staff::where('email',auth()->user()->email)->first();
            $SUBID = DB::table('subject_staff')
                ->join('subjects', 'subjects.id', '=', 'subject_staff.subject_id')
                ->where('staff_id', $staff->id)->distinct()->get(['__class_id']);
            foreach ($SUBID as $sub){
                $live =  LiveClass::where('class_id', $sub->__class_id)->latest()->get();
                foreach ($live as $l){
                    array_push($data, $l);
                }
            }
            return view('live-classes.index', compact('data'));
        }

        $data = LiveClass::latest()->get();
        return view('live-classes.index', compact('data'));
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
            return view('live-classes.create', compact('classes'));
        }
        $classes = _Class::latest()->get();
        return view('live-classes.create', compact('classes'));
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
                'meeting_link' => 'required',
            ]);

            LiveClass::create([
                'class_id' => $request->class_id,
                'user_id' => auth()->user()->id,
                'meeting_link' => $request->meeting_link,
            ]);

            DB::commit();
            return redirect()->route('live-classes.index')
                ->with('success','Link saved successfully');
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
            $data = LiveClass::findOrFail($id);
            return view('live-classes.edit', compact('classes', 'data'));
        }
        $classes = _Class::latest()->get();
        $data = LiveClass::findOrFail($id);
        return view('live-classes.edit', compact('classes', 'data'));
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
                'meeting_link' => 'required',
                'status' => 'required',
            ]);

            LiveClass::where('id', $id)->update([
                'class_id' => $request->class_id,
                'user_id' => auth()->user()->id,
                'meeting_link' => $request->meeting_link,
                'status' => $request->status,
            ]);

            DB::commit();
            return redirect()->route('live-classes.index')
                ->with('success','Link saved successfully');
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
            LiveClass::where('id', $id)->delete();
            DB::commit();
            return redirect()->route('live-classes.index')
                ->with('success','Link deleted successfully');
        }
        catch (\Exception $exception){
            DB::rollBack();
            return redirect()->back()
                ->with('error',$exception->getMessage());
        }
    }
}
