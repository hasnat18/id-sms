<?php

namespace App\Http\Controllers;

use App\Models\Department;
use App\Models\Staff;
use App\Models\User;
use Illuminate\Http\Request;
use App\Models\Transport;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use function Spatie\LaravelIgnition\Recorders\JobRecorder\start;
use Auth;

class StaffController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:staff-list|staff-create|staff-edit|staff-delete', ['only' => ['index','store']]);
        $this->middleware('permission:staff-create', ['only' => ['create','store']]);
        $this->middleware('permission:staff-edit', ['only' => ['edit','update']]);
        $this->middleware('permission:staff-delete', ['only' => ['destroy']]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = Staff::latest()
                    ->whereHas('users.department', function ($query) {
                        $query->where('name', '!=', 'Teacher');
                    })
                    ->get();
        return view('staffs.index', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $deps = Department::latest()->get();
        $transports = Transport::latest()->get();
        $roles = Role::all();
        return view('staffs.create', compact('deps', 'transports', 'roles'));
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
            "department" => 'required',
            "is_bus_incharge" => 'required',
            "transport_id" => 'nullable',
            'roles' => 'required',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make('staff123')
        ]);

        $user->assignRole($request->input('roles'));

        $user->department()->associate($request->department)->save();

        $staff = new Staff();
        $staff->name = $request->name;
        $staff->gender = $request->gender;
        $staff->dob = $request->dob;
        $staff->address = $request->address;
        $staff->phone = $request->phone;
        $staff->email = $request->email;
        $staff->joining_date = $request->joining_date;
        $staff->salary = $request->salary;
        $staff->is_bus_incharge = $request->is_bus_incharge;
        $staff->transport_id = $request->transport_id;
        $staff->user_id = $user->id;
        $staff->added_by = Auth::user()->id;
       
        if ($request->id_proof !== null){
            $img = time().'.' . $request->id_proof->getClientOriginalExtension();
            \Image::make($request->id_proof)->save(public_path('uploads/staffs/').$img);
            $staff->id_proof = $img;
        }
        $staff->save();
        
        return redirect()->route('staffs.index')
            ->with( 'success', 'Record created.....' );
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
        return view('staffs.show', compact('data', 'userRole', 'rolePermissions'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data = Staff::findOrFail($id);
        $deps = Department::latest()->get();
        $transports = Transport::latest()->get();
        $roles = Role::all();
        $userRole = $data->users->roles->first();
        return view('staffs.edit', compact('data', 'userRole', 'deps', 'transports', 'roles'));
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
      
        $data = $request->validate([
            "id_proof" => 'nullable',
            "name" => 'required',
            "gender" => 'required',
            "dob" => 'required',
            "address" => 'required',
            "phone" => 'required',
            "email" => 'required|unique:staffs,email,'.$id,
            "joining_date" => 'required',
            "salary" => 'required',
            "department" => 'required',
            "is_bus_incharge" => 'required',
            "transport_id" => 'nullable',
            'roles' => 'required',
        ]);

    
        $staff = Staff::findOrFail($id);

        $user = User::where('id', $staff->user_id)->first();
        $user->email = $request->email;
        $user->update();

        DB::table('model_has_roles')->where('model_id',$user->id)->delete();
        $user->assignRole($request->input('roles'));

        $user->department()->associate($request->department)->save(); 
        $staff->name = $request->name;
        $staff->gender = $request->gender;
        $staff->dob = $request->dob;
        $staff->address = $request->address;
        $staff->phone = $request->phone;
        $staff->email = $request->email;
        $staff->joining_date = $request->joining_date;
        $staff->salary = $request->salary;
        $staff->is_bus_incharge = $request->is_bus_incharge;
        $staff->transport_id = $request->transport_id;
        $staff->user_id = $user->id;
        $staff->added_by = Auth::user()->id;
        if ($request->id_proof != null){
            $img = time().'.' . $request->id_proof->getClientOriginalExtension();
            \Image::make($request->id_proof)->save(public_path('uploads/staffs/').$img);
            $staff->id_proof = $img;
        }
        $staff->update();

        return redirect()->route('staffs.index')
            ->with( 'success', 'Record updated' );
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

            Staff::where('id', $id)->delete();

            DB::commit();
            return redirect()->route('staffs.index')
                ->with( 'success', 'Record deleted.....' );
        }
        catch (\Exception $exception){
            DB::rollBack();
            return redirect()->back()->with('error',$exception->getMessage());
        }
    }
}
