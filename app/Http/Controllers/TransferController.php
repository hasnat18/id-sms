<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\Transfer;
use App\Models\Admission;
use Illuminate\Http\Request;

class TransferController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:transfer-list|transfer-create|transfer-edit|transfer-delete', ['only' => ['index','store']]);
        $this->middleware('permission:transfer-create', ['only' => ['create','store']]);
        $this->middleware('permission:transfer-edit', ['only' => ['edit','update']]);
        $this->middleware('permission:transfer-delete', ['only' => ['destroy']]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = Transfer::latest()->get();
        return view('transfers.index', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $admissions = Admission::where('status', 'admitted')->latest()->get();
        return view('transfers.create', compact('admissions'));
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
             $request->validate([
                'admission_id' => 'required',
                'school_name' => 'required',
                'class_name' => 'required',
                'doc' => 'nullable'
            ]);

             $chk = Transfer::where('admission_id', $request->admission_id)->first();
             if ($chk !== null){
                 return redirect()->back()->with('error','This student is alraedy transferred.');
             }

             $data = new Transfer();
             $data->admission_id = $request->admission_id;
             $data->school_name = $request->school_name;
             $data->class_name = $request->class_name;

             if ($request->doc !== null){
                 $img = time().'.' . $request->doc->getClientOriginalExtension();
                 \Image::make($request->doc)->save(public_path('uploads/transfers/').$img);
                 $data->doc = $img;
             }
             $data->save();

            Admission::where('id', $request->admission_id)->update(['status' => 'transferred out']);

            Student::where('admission_id', $request->admission_id)->update(['status' => 'transferred out']);

            return redirect()->route('transfers.index')
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
        $data = Transfer::findOrFail($id);
        return view('transfers.show', compact('data'));

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data = Transfer::findOrFail($id);
        $admission = Admission::find($data->admission_id);
        return view('transfers.edit', compact('data', 'admission'));
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
            $request->validate([
                'admission_id' => 'required',
                'school_name' => 'required',
                'class_name' => 'required',
                'doc' => 'nullable'
            ]);

            $chk = Transfer::where('admission_id', $request->admission_id)->first();
            if ($chk !== null){
                return redirect()->back()->with('error','This student is alraedy transferred.');
            }

            $data = Transfer::findOrFail($id);
            $data->admission_id = $request->admission_id;
            $data->school_name = $request->school_name;
            $data->class_name = $request->class_name;

            if ($request->doc !== null){
                $img = time().'.' . $request->doc->getClientOriginalExtension();
                \Image::make($request->doc)->save(public_path('uploads/transfers/').$img);
                $data->doc = $img;
            }
            $data->save();

            return redirect()->route('transfers.index')
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
            $data = Transfer::findOrFail($id);
            $data->delete();
            return redirect()->route('transfers.index')
                ->with( 'success', 'Record deleted.....' );
        }
        catch (\Exception $exception){
            return redirect()->back()->with('error',$exception->getMessage());
        }
    }
}
