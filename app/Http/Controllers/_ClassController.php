<?php

namespace App\Http\Controllers;

use App\Models\_Class;
use App\Models\Staff;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class _ClassController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:class-list|class-create|class-edit|class-delete', ['only' => ['index','store']]);
        $this->middleware('permission:class-create', ['only' => ['create','store']]);
        $this->middleware('permission:class-edit', ['only' => ['edit','update']]);
        $this->middleware('permission:class-delete', ['only' => ['destroy']]);
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
            $staff = Staff::where('email', auth()->user()->email)->first();
            $SUBID = DB::table('subject_staff')
                ->join('subjects', 'subjects.id', '=', 'subject_staff.subject_id')
                ->where('staff_id', $staff->id)->distinct()->get(['__class_id']);
            foreach ($SUBID as $sub){
                $cl = _Class::find($sub->__class_id);
                array_push($data, $cl);
            }
            return view('classes.index',compact('data'));
        }
        $data = _Class::latest()->get();
        return view('classes.index',compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('classes.create');
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
            $data = $request->validate([
                'section_id'=>'required',
                'name'=>'required',
            ]);

            _Class::create($data);

            return redirect()->route('classes.index')
                ->with('success','Class created successfully');
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
        $data = _Class::findOrFail($id);
        return view('classes.show', compact('data'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data = _Class::findOrFail($id);
        return view('classes.edit', compact('data'));
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
            $data = $request->validate([
                'section_id'=>'required',
                'name'=>'required',
            ]);

            _Class::where('id', $id)->update($data);

            return redirect()->route('classes.index')
                ->with('success','Class updated successfully');
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

            $data = _Class::findOrFail($id);
            $data->delete();
            return redirect()->route('classes.index')
                ->with('success','Class deleted successfully');
        }
        catch (\Exception $exception){
            return redirect()->back()
                ->with('error',$exception->getMessage());
        }
    }
}
