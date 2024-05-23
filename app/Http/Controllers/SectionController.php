<?php

namespace App\Http\Controllers;

use App\Models\Section;
use Illuminate\Http\Request;

class SectionController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:section-list|section-create|section-edit|section-delete', ['only' => ['index','store']]);
        $this->middleware('permission:section-create', ['only' => ['create','store']]);
        $this->middleware('permission:section-edit', ['only' => ['edit','update']]);
        $this->middleware('permission:section-delete', ['only' => ['destroy']]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = Section::latest()->get();
        return view('sections.index', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('sections.create');
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
                'name' => 'required'
            ]);

            $section = Section::create($data);
            return redirect()->route('sections.index')
                ->with('success','Section created successfully');
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
        $data = Section::findOrFail($id);
        return view('sections.edit', compact('data'));
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
                'name' => 'required'
            ]);
            Section::where('id', $id)->update($data);
            return redirect()->route('sections.index')
                ->with('success','Section updated successfully');
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
            $data = Section::findOrFail($id);
            $data->delete();
            return redirect()->route('sections.index')
                ->with('success','Section deleted successfully');
        }
        catch (\Exception $exception){
            return redirect()->back()
                ->with('error',$exception->getMessage());
        }
    }
}
