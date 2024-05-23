<?php

namespace App\Http\Controllers;

use App\Models\Transport;
use Illuminate\Http\Request;

class TransportController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:transport-list|transport-create|transport-edit|transport-delete', ['only' => ['index','store']]);
        $this->middleware('permission:transport-create', ['only' => ['create','store']]);
        $this->middleware('permission:transport-edit', ['only' => ['edit','update']]);
        $this->middleware('permission:transport-delete', ['only' => ['destroy']]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = Transport::latest()->get();
        return view('transports.index', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('transports.create');
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
                "vehicle_number" => 'required',
                  "vehicle_model" => 'required',
                  "driver_name" => 'required',
                  "driver_phone" => 'required',
                  "note" => 'nullable',
            ]);

            Transport::create($data);

            return redirect()->route('transports.index')
                ->with('success','Transport created successfully');
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
        $data = Transport::findOrFail($id);
        return view('transports.edit', compact('data'));
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
                "vehicle_number" => 'required',
                "vehicle_model" => 'required',
                "driver_name" => 'required',
                "driver_phone" => 'required',
                "note" => 'nullable',
            ]);

            Transport::where('id', $id)->update($data);

            return redirect()->route('transports.index')
                ->with('success','Transport updated successfully');
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
            Transport::where('id', $id)->delete();
            return redirect()->route('transports.index')
                ->with('success','Transport deleted successfully');
        }
        catch (\Exception $exception){
            return redirect()->back()
                ->with('error',$exception->getMessage());
        }
    }
}
