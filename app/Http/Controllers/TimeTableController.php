<?php

namespace App\Http\Controllers;

use App\Models\_Class;
use App\Models\Admission;
use App\Models\Salary;
use App\Models\Staff;
use App\Models\Student;
use App\Models\StudyMaterial;
use App\Models\Subject;
use App\Models\TimeTable;
use App\Services\TimeSlotService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class TimeTableController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:time-table-list|time-table-create|time-table-edit|time-table-delete', ['only' => ['index', 'store']]);
        $this->middleware('permission:time-table-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:time-table-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:time-table-delete', ['only' => ['destroy']]);
    }

    public function getTimetable($id)
    {
       return TimeTable::with('subject._class')->where('__class_id', $id)->get();
    }

    public function getSubjectsByClass($id)
    {
        return Subject::where('__class_id', $id)->get();
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
            $timetable = TimeTable::where('__class_id', $st->__class_id)->latest()->get();
            return view('timetables.index',compact('timetable'));
        }

        if ( auth()->user()->is_teacher ){
            $timetable = array();
            $staff = Staff::where('email',auth()->user()->email)->first();
            $SUBID = DB::table('subject_staff')
                ->join('subjects', 'subjects.id', '=', 'subject_staff.subject_id')
                ->where('staff_id', $staff->id)->distinct()->get(['__class_id']);
            foreach ($SUBID as $sub){
                $tt = TimeTable::where('__class_id', $sub->__class_id)->latest()->get();
                foreach ($tt as $t){
                    array_push($timetable, $t);
                }
            }
            return view('timetables.index',compact('timetable'));
        }

        $timetable = TimeTable::latest()->get();
        return view('timetables.index',compact('timetable'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $classes = _Class::all();
        $subjects = Subject::all();
        $timeslots = new TimeSlotService();

//        dd($timeslots->timeslotarray());
        return view('timetables.create', compact('classes', 'subjects','timeslots'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
//        dd($request);
        DB::beginTransaction();

        try {
            $data = $request->validate([
                "__class_id" => "required",
                "subject_id" => "required",
                "start_time" => "required",
                "end_time" => "required",
                "day" => "required",
            ]);

            $data1 = TimeTable::where('__class_id', $request->__class_id)
                ->where('start_time', $request->start_time)
                ->where('end_time', $request->end_time)
                ->where('day', $request->day)->first();

            if($data1 !== null){
                DB::rollBack();
                return redirect()->back()->with('error','Time Slot Already Exist ');
            }

            TimeTable::create($data);

            DB::commit();
            return redirect()->route('time-tables.create')
                ->with('success', 'Record updated.....');

        } catch (\Exception $exception) {
            DB::rollBack();
            return redirect()->back()->with('error', $exception->getMessage());
        }
    }


    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $classes = _Class::all();
        $subjects = Subject::all();
        $timeslots = new TimeSlotService();
        $data = TimeTable::findOrFail($id);
//        dd($data);

//        dd($timeslots->timeslotarray());
        return view('timetables.edit', compact('classes', 'subjects','timeslots','data'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        {
            DB::beginTransaction();
            try {
                TimeTable::find($id)->delete();
                DB::commit();
                return redirect()->route('time-tables.index')
                    ->with('success','Row deleted successfully');
            }
            catch (\Exception $exception){
                DB::rollBack();
                return redirect()->back()
                    ->with('error',$exception->getMessage());
            }
        }
    }
}
