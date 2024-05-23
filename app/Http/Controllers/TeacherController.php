<?php

namespace App\Http\Controllers;

use Image;
use App\Models\User;
use App\Models\Staff;
use App\Models\Subject;
use App\Models\SUBSTAFF;
use App\Models\Department;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Permission;

class TeacherController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:teacher-list|teacher-create|teacher-edit|teacher-delete', ['only' => ['index','store']]);
        $this->middleware('permission:teacher-create', ['only' => ['create','store']]);
        $this->middleware('permission:teacher-edit', ['only' => ['edit','update']]);
        $this->middleware('permission:teacher-delete', ['only' => ['destroy']]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $teachers = DB::table('users')
            ->join('staffs', 'users.id', '=', 'staffs.user_id')
            ->join('departments', 'users.department_id', '=', 'departments.id')
            ->select('staffs.*')->where('departments.name', 'Teacher')
            ->get();

        return view('teachers.index', compact('teachers'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('teachers.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            "name" => 'required',
            "id_proof" => 'required',
            "gender" => 'required',
            "dob" => 'required',
            "address" => 'required',
            "phone" => 'required',
            "email" => 'required|unique:staffs,email',
            "joining_date" => 'required',
            "salary" => 'required',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make('teacher123')
        ]);

        $role = Role::where('name', 'teacher')->first();
        $department = Department::where('name', 'Teacher')->first();

        $user->assignRole($role->id);

        $user->department()->associate($department->id)->save();

        $staff = new Staff();
        $staff->name = $request->name;
        $staff->gender = $request->gender;
        $staff->dob = $request->dob;
        $staff->address = $request->address;
        $staff->phone = $request->phone;
        $staff->email = $request->email;
        $staff->joining_date = $request->joining_date;
        $staff->salary = $request->salary;
        $staff->user_id = $user->id;
        $staff->added_by = Auth::user()->id;
        if ($request->id_proof !== null){
            $img = time().'.' . $request->id_proof->getClientOriginalExtension();
            Image::make($request->id_proof)->save(public_path('uploads/staffs/').$img);
            $staff->id_proof = $img;
        }
        $staff->save();
        
        return redirect()->route('teachers.index')
            ->with( 'success', 'Record created.....' );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function assignSubjects(Request $request)
    {
        DB::beginTransaction();
        try {

            $request->validate([
                "staff_id" => "required",
                "subjects" => "required",
            ]);

            $countSubjects = count($request->subjects);

            for ($i = 0; $i < $countSubjects; $i++){
                $subject_id = $request->subjects[$i];
                $subject_staff = SUBSTAFF::where('staff_id', $request->staff_id)->where('subject_id', $subject_id)->first();
            
                if(!$subject_staff){
                    SUBSTAFF::create([
                        "staff_id" => $request->staff_id,
                        "subject_id" => $subject_id,
                    ]);
                } else {
                    $subject_staff->delete();
                }
            }
            
            DB::commit();
            return redirect()->route('teachers.index')
                ->with( 'success', 'Record created.....' );
        }
        catch (\Exception $exception){
            DB::rollBack();
            return redirect()->back()->with('error',$exception->getMessage());
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
        $data = Staff::findOrFail($id);
        $user = User::where('id', $data->user_id)->first();
        $userRole = $user->roles->first();
        $rolePermissions = Permission::join("role_has_permissions","role_has_permissions.permission_id","=","permissions.id")
            ->where("role_has_permissions.role_id",$userRole->id)
            ->get();
        return view('teachers.show', compact('data', 'userRole', 'rolePermissions'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $staff_id = $id;
        $staff = Staff::findOrFail($id);
        $subjects = Subject::latest()->get();
        return view('teachers.assign', compact('subjects', 'staff_id', 'staff'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function revokeSubject($staffId, $subjectId)
    {
        DB::beginTransaction();
        try {
            $subjectStaff = SUBSTAFF::where('staff_id', $staffId)->where('subject_id', $subjectId)->first();
            if (!$subjectStaff) {
                throw new \Exception('Subject not found');
            }
            $subjectStaff->delete();
            DB::commit();
            return redirect()->back()->with('success', 'Subject Revoked.....' );;
        } catch (\Exception $exception) {
            DB::rollBack();
            return redirect()->back()->with('error',$exception->getMessage());
        }
    }
    
}
