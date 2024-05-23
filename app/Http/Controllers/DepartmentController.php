<?php

namespace App\Http\Controllers;

use App\Models\Department;
use Illuminate\Http\Request;

class DepartmentController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:department-list|department-create|department-edit|department-delete', ['only' => ['index','store']]);
        $this->middleware('permission:department-create', ['only' => ['create','store']]);
        $this->middleware('permission:department-edit', ['only' => ['edit','update']]);
        $this->middleware('permission:department-delete', ['only' => ['destroy']]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $data = Department::latest()->get();
        return view('departments.index',compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('departments.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {
            $data  = $this->validate($request, [
                'name' => 'required',
            ]);
            Department::create($data);
            return redirect()->route('departments.index')
                ->with('success','Department created successfully');
        }
        catch (\Exception $exception){
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
        $data = Department::findOrFail($id);
        return view('departments.edit', compact('data'));
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
        try {
            $this->validate($request, [
                'name' => 'required',
            ]);

            $data = Department::findOrFail($id);
            $data->name = $request->name;
            $data->update();

            return redirect()->route('departments.index')
                ->with('success','Department updated successfully');
        }
        catch (\Exception $exception){
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
        try {
            $data = Department::findOrFail($id);
            $data->delete();

            return redirect()->route('departments.index')
                ->with('success','Department deleted successfully');
        }
        catch (\Exception $exception){
            return redirect()->back()
                ->with('error',$exception->getMessage());
        }
    }
}
