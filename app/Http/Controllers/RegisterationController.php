<?php

namespace App\Http\Controllers;

use App\Models\_Class;
use App\Models\Registration;
use Illuminate\Http\Request;

class RegisterationController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:reg-list', ['only' => ['getRegistrations']]);
        $this->middleware('permission:reg-status-change', ['only' => ['admissionCancel']]);
    }

    public function admissionCancel($id)
    {
        try {
            Registration::where('id', $id)->update([ 'status' => 'cancelled' ]);
            return redirect()->route('registrations.students')
                ->with('success','Registration is cancelled.');
        }
        catch (\Exception $exception){
            return redirect()->back()
                ->with('error',$exception->getMessage());
        }
    }

    public function getRegistrations()
    {
        $data = Registration::latest()->get();
        return view('registrations.index', compact('data'));
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $classes = _Class::distinct()->get(['name']);
        return view('registrations', compact('classes'));
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
                "student_name" => 'required',
              "gender" => 'required',
              "dob" => 'required',
              "religion" => 'required',
              "cast" => 'required',
              "blood_group" => 'nullable',
              "phone" => 'required',
              "email" => 'required',
              "address" => 'required',
              "city" => 'required',
              "state" => 'required',
              "country" => 'required',
              "extra_note" => 'nullable',
              "father_name" => 'required',
              "father_phone" => 'nullable',
              "father_occ" => 'nullable',
              "mother_name" => 'required',
              "mother_phone" => 'nullable',
              "mother_occ" => 'nullable',
              "class_name" => 'required',
            ]);

            $reg = Registration::create($data);

            return redirect()->back()
                ->with('success','Your request is submitted your registration ID is ... '.$reg->id);
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
        $data = Registration::findOrFail($id);
        return view('registrations.show', compact('data'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
