<?php

namespace App\Http\Controllers;

use App\Models\_Session;
use Illuminate\Http\Request;

class _SessionController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:session-list|session-create|session-edit|session-delete', ['only' => ['index','store']]);
        $this->middleware('permission:session-create', ['only' => ['create','store']]);
        $this->middleware('permission:session-edit', ['only' => ['edit','update']]);
        $this->middleware('permission:session-delete', ['only' => ['destroy']]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = _Session::latest()->get();
        return view('_sessions.index', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('_sessions.create');
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
                'start_date' => 'required',
                'end_date' => 'required',
                'status' => 'required'
            ]);

            $sess = _Session::create($data);

            if ($request->status == 1){
                _Session::whereNot('id', $sess->id)->update([ 'status' => false ]);
            }

            return redirect()->route('yearly-session.index')
                ->with('success','Session created successfully');
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
        $data = _Session::findOrFail($id);
        return view('_sessions.edit', compact('data'));
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
                'start_date' => 'required',
                'end_date' => 'required',
                'status' => 'required'
            ]);

            _Session::where('id', $id)->update($data);

            if ($request->status == 1){
                _Session::whereNot('id', $id)->update([ 'status' => false ]);
            }

            return redirect()->route('yearly-session.index')
                ->with('success','Session updated successfully');
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
            _Session::where('id', $id)->update(['status' => false]);
            return redirect()->route('yearly-session.index')
                ->with('success','Session deleted successfully');
        }
        catch (\Exception $exception){
            return redirect()->back()
                ->with('error',$exception->getMessage());
        }
    }
}
