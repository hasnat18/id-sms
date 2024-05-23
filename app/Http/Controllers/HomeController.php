<?php

namespace App\Http\Controllers;

use App\Models\_Class;
use App\Models\Admission;
use App\Models\Department;
use App\Models\Fees;
use App\Models\LiveClass;
use App\Models\Registration;
use App\Models\Salary;
use App\Models\StaffLeave;
use App\Models\StudentLeave;
use App\Models\Transport;
use App\Models\User;
use LaravelDaily\LaravelCharts\Classes\LaravelChart;
use App\Models\NoticeBoard;
use App\Models\_Session;
use App\Models\Student;
use App\Models\TimeTable;
use App\Models\Staff;
use App\Models\StaffAttendence;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Carbon\Carbon;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $announcement = NoticeBoard::latest()->first();
        $notice = null;

        if(isset($announcement)){

            $start_date = Carbon::parse($announcement->start_date);
            $end_date = Carbon::parse($announcement->end_date);
            $today = Carbon::today();
            if ($today->greaterThanOrEqualTo($start_date) && $today->lessThanOrEqualTo($end_date)) {
                // Notice is active, create a JSON object with title and content
                $notice = json_decode(json_encode([
                    'title' => $announcement->title,
                    'notice' => $announcement->notice,
                ]));
            } else {
                // Notice is not active, set $notice to null
                $notice = null;
            }
        }

        //Teacher
        if(auth()->user()->is_teacher){
            $data = Staff::where('user_id',auth()->user()->id)->first();
            $present = count(StaffAttendence::where('staff_id',$data->id)->where('status','present')->get());
            $absent = count(StaffAttendence::where('staff_id',$data->id)->where('status','absent')->get());
            $leave = count(StaffAttendence::where('staff_id',$data->id)->where('status','leave')->get());
            $late = count(StaffAttendence::where('staff_id',$data->id)->where('status','late')->get());
            $SESSIONID = _Session::where('status', 1)->first();
            $data1 = array();
            $SUBID = DB::table('subject_staff')
            ->join('subjects', 'subjects.id', '=', 'subject_staff.subject_id')
            ->where('staff_id', $data->id)->distinct()->get(['__class_id']);
            foreach ($SUBID as $sub){
                $std = Student::where('__class_id', $sub->__class_id)->where('__session_id', $SESSIONID->id)->get();
                foreach($std as $student){
                    array_push($data1, $student);
                }
            }
            $transport = $data->transport;
            $SUB = DB::table('subject_staff')->where('staff_id',$data->id)->distinct()->get(['subject_id']);

            //TimeTable
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
            //salary chart
            $salary = Salary::where('staff_id',$data->id)->latest()->first();
            $totalSalary = Salary::where('staff_id', $data->id)->sum('salary');
            return view('home',compact('present','absent','leave','data','notice','late','data1','SUBID','transport','SUB','timetable','salary','totalSalary'));
        }

        // Student
        if(auth()->user()->is_student){
            $d = Admission::where('student_auth_id',auth()->user()->id)->first();
            $transport = $d->st;
            $fee = Fees::where('admission_id',$d->id)->latest()->first();
            $livelink = LiveClass::where('class_id',$d->__class_id)->latest()->first();
            $fees = Fees::where('admission_id',$d->id)->get();
            $minmax = DB::table('fees')->select(\DB::raw('MIN(total) AS DateStart, MAX(total) AS DateEnd'))->first();

            return view('home',compact('d','transport','fee','notice','livelink','fees','minmax'));
        }

        if(auth()->user()->is_admin){
            $dep = count(Department::get()->all());
            $user = count(User::get()->all());
            $stu = count(Student::get()->all());
            $staff = count(Staff::get()->all());
            $teacher = DB::table('users')
            ->join('staffs', 'users.id', '=', 'staffs.user_id')
            ->join('departments', 'users.department_id', '=', 'departments.id')
            ->select('staffs.*')->where('departments.name', 'Teacher')
            ->get();
            $transport = count(Transport::get()->all());
            $pen_salaries = count(Salary::where('status','pending')->get());
            $pen_Sleaves = count(StaffLeave::where('status','pending')->get());
            $pen_stuleaves = count(StudentLeave::where('status','pending')->get());
            $pen_fee = count(Fees::where('status','pending')->get());
            $admission = count(Admission::get());
            $admission_p = count(Admission::where('status','pending')->get());
            $minmax = DB::table('admissions')->select(\DB::raw('MIN(id) AS min, MAX(id) AS max'))->first();
            $minmax1 = DB::table('admissions')->select(\DB::raw('MIN(id) AS mins, MAX(id) AS maxs'))->first();

            $STUDENTCLASSESARRAY = array('class_name' => [], 'students_total' => []);
            $classes = _Class::get();
            foreach ($classes as $class){
                $stucent_count = count( Student::where('__class_id', $class->id)->get() );
                array_push($STUDENTCLASSESARRAY['class_name'], $class->name.' - '.$class->section->name );
                array_push($STUDENTCLASSESARRAY['students_total'], $stucent_count );
            }

            $STUDENTCLASSESARRAY = json_encode($STUDENTCLASSESARRAY);

            return view('home',compact('dep','user','stu','staff','teacher','transport',
                'pen_salaries','pen_Sleaves','pen_stuleaves','pen_fee', 'STUDENTCLASSESARRAY','admission','admission_p','minmax','minmax1','notice'));
        }

        return view('home');
    }


}
