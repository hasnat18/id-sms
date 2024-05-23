<?php

namespace App\Http\Controllers;

use App\Models\Department;
use App\Models\User;
use Illuminate\Http\Request;
use Auth;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use Hash;

class UserController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:user-list|user-create|user-edit|user-delete', ['only' => ['index','store']]);
        $this->middleware('permission:user-create', ['only' => ['create','store']]);
        $this->middleware('permission:user-edit', ['only' => ['edit','update']]);
        $this->middleware('permission:user-delete', ['only' => ['destroy']]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = User::whereNot('id', Auth::user()->id)->latest()->get();
        return view('users.index', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $roles = Role::pluck('name','name')->all();
        $department = Department::pluck('name', 'id')->all();
        return view('users.create', compact('roles', 'department'));
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
            $data = $request->validate([
                "name" => 'required|string',
                "email" => 'required|unique:users,email',
                "roles" => 'required',
                "department" => 'required',
            ]);

            $user = new User();
            $user->name = $request->name;
            $user->email = $request->email;
            $user->password = Hash::make('user1234');
            $user->save();

            $user->assignRole($request->input('roles'));
            $user->department()->associate($request->department)->save();

            // $user->departments()->sync($request->department);
            DB::commit();
            return redirect()->route('users.index')
                ->with('success','User created successfully');
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
        $user = User::find($id);
        $roles = Role::pluck('name','name')->all();
        $userRole = $user->roles->pluck('name','name')->all();

        $departments = Department::pluck('name','id')->all();
         $userDep =Department::latest()->first();
        // $userDep = $user->departments->first();
        
        return view('users.edit',compact('user','roles','userRole', 'departments', 'userDep'));
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
            $data = $request->validate([
                "name" => 'required|string',
                "email" => 'required|unique:users,email,'.$id,
                "roles" => 'required',
                "department" => 'required',
            ]);

            $user = User::findOrFail($id);
            $user->update($data);

            DB::table('model_has_roles')->where('model_id',$id)->delete();
            $user->assignRole($request->input('roles'));
             $user->department()->associate($request->department)->save();
            // $user->departments()->sync($request->department);

            DB::commit();
            return redirect()->route('users.index')
                ->with('success','User updated successfully');
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
            User::find($id)->delete();
            DB::commit();
            return redirect()->route('users.index')
                ->with('success','User deleted successfully');
        }
        catch (\Exception $exception){
            DB::rollBack();
            return redirect()->back()
                ->with('error',$exception->getMessage());
        }
    }

    public function profileView()
    {
        return view('users.profile');
    }

    public function changeProfile(Request $request)
    {
        try {
            $request->validate([
                "name" => 'required',
                "email" => 'required|unique:users,email,'.Auth::user()->id,
                "current_password" => 'required',
                "new_password" => 'nullable',
            ]);

            $user = User::where('email', $request->email)->first();
            $chkPassword = Hash::check(request('current_password'), $user->password);
            if ($chkPassword !== true){
                return redirect()->back()
                    ->with('error',"Current password don't match");
            }

            $user->name = $request->name;
            $user->email = $request->email;
            if ($request->new_password !== null){
                $user->password = Hash::make($request->new_password);
            }
            $user->update();
            return redirect()->route('users.profile')
                ->with('success','User details saved successfully');
        }
        catch (\Exception $exception){
            return redirect()->back()
                ->with('error',$exception->getMessage());
        }
    }
}
