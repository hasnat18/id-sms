<?php

namespace App\Http\Controllers;

use App\Models\Gatepass;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class GatePassController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = Gatepass::latest()->get();
        return view('gate-pass.index',compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('gate-pass.create');

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
    //   dd($request);

        DB::beginTransaction();
        try {
                $request->validate([
                "name" => 'required',
                "phone_number" => 'nullable',
                "address" => 'nullable',
                "cnic" => 'nullable',
                "relation" => 'nullable',
                "time_out" => 'required',
                "time_in" => 'required',
            ]);

                Gatepass::create([
                "name" => $request->name,
                "phone_number" => $request->phone_number,
                "address" => $request->address,
                'cnic' => $request->cnic,
                'relation' => $request->relation,
                'time_out' => $request->time_out,
                'time_in' => $request->time_in,
            ]);
            DB::commit();
            return redirect()->route('gate-pass.index')
                ->with('success','Entry Successfully..!!');
        }
        catch (\Exception $exception){
            DB::rollBack();
            return redirect()->route('gate-pass.index')
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
        $data = Gatepass::findOrFail($id);
        return view('gate-pass.edit',compact('data'));
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
//        dd($request);

        DB::beginTransaction();
        try {
            $request->validate([
                "name" => 'required',
                "phone_number" => 'nullable',
                "address" => 'nullable',
                "cnic" => 'nullable',
                "relation" => 'nullable',
                "time_out" => 'required',
                "time_in" => 'required',
            ]);

            Gatepass::where('id', $id)->update([
                "name" => $request->name,
                "phone_number" => $request->phone_number,
                "address" => $request->address,
                'cnic' => $request->cnic,
                'relation' => $request->relation,
                'time_out' => $request->time_out,
                'time_in' => $request->time_in,
            ]);
            DB::commit();
            return redirect()->route('gate-pass.index')
                ->with('success','Entry Successfully..!!');
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
            Gatepass::find($id)->delete();
            DB::commit();
            return redirect()->route('gate-pass.index')
                ->with('success','Entry Deleted successfully');
        }
        catch (\Exception $exception){
            DB::rollBack();
            return redirect()->back()
                ->with('error',$exception->getMessage());
        }
    }
}
