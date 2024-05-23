<?php

namespace App\Http\Controllers;

use App\Models\_Class;
use App\Models\Staff;
use App\Models\Subject;
use Illuminate\Http\Request;

class SubjectController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:subject-list|subject-create|subject-edit|subject-delete', ['only' => ['index','store']]);
        $this->middleware('permission:subject-create', ['only' => ['create','store']]);
        $this->middleware('permission:subject-edit', ['only' => ['edit','update']]);
        $this->middleware('permission:subject-delete', ['only' => ['destroy']]);
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
            foreach ($staff->subjects as $sub){
                array_push($data, $sub);
            }
            return view('subjects.index',compact('data'));
        }
        $data = Subject::latest()->get();
        return view('subjects.index', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $_classes = _Class::latest()->get();
        return view('subjects.create', compact('_classes'));
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
                '__class_id' => 'required',
                'name' => 'required'
            ]);
            Subject::create($data);
            return redirect()->route('subjects.index')
                ->with( 'success', 'Record created.....' );
        }
        catch (\Exception $exception){
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
        $data = Subject::findOrFail($id);
        $_classes = _Class::latest()->get();
        return view('subjects.edit', compact('data', '_classes'));
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
                '__class_id' => 'required',
                'name' => 'required'
            ]);
            Subject::where('id', $id)->update($data);
            return redirect()->route('subjects.index')
                ->with( 'success', 'Record updated.....' );
        }
        catch (\Exception $exception){
            return redirect()->back()->with('error',$exception->getMessage());
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
            Subject::where('id', $id)->delete();
            return redirect()->route('subjects.index')
                ->with( 'success', 'Record deleted.....' );
        }
        catch (\Exception $exception){
            return redirect()->back()->with('error',$exception->getMessage());
        }
    }
}
