<?php

namespace App\Http\Controllers;

use App\Models\NoticeBoard;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class NoticeBoradController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:notice-list|notice-create|notice-edit|notice-delete', ['only' => ['index','store']]);
        $this->middleware('permission:notice-create', ['only' => ['create','store']]);
        $this->middleware('permission:notice-edit', ['only' => ['edit','update']]);
        $this->middleware('permission:notice-delete', ['only' => ['destroy']]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = NoticeBoard::latest()->get();
        return view('notices.index', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('notices.create');
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
            $request->validate([
                'title' => 'required',
                'notice' => 'required',
                'start_date' => 'nullable',
                'end_date' => 'nullable',
            ]);

            NoticeBoard::create([
                'title' => $request->title,
                'notice' => $request->notice,
                'start_date' => $request->start_date,
                'end_date' => $request->end_date,
                'user_id' => auth()->user()->id,
            ]);

            DB::commit();
            return redirect()->route('notices.index')
                ->with('success','Notice saved successfully');
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
        $note = NoticeBoard::findOrFail($id);
//        $fds = FeeDetails::where('fee_id',$id)->get();
//        $r = Result::findOrFail($id);
//        $rds = ResultDetail::where('result_id', $id)->get();
//        dd($data1);
        return view('notices.show', compact('note'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data = NoticeBoard::findOrFail($id);
        return view('notices.edit', compact('data'));
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
            $request->validate([
                'title' => 'required',
                'notice' => 'required',
                'start_date' => 'nullable',
                'end_date' => 'nullable',
                'status' => 'required',
            ]);

            NoticeBoard::where('id', $id)->update([
                'title' => $request->title,
                'notice' => $request->notice,
                'start_date' => $request->start_date,
                'end_date' => $request->end_date,
                'user_id' => auth()->user()->id,
                'status' => $request->status,
            ]);

            DB::commit();
            return redirect()->route('notices.index')
                ->with('success','Notice updated successfully');
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

            NoticeBoard::where('id', $id)->delete();

            DB::commit();
            return redirect()->route('notices.index')
                ->with('success','Notice deleted successfully');
        }
        catch (\Exception $exception){
            DB::rollBack();
            return redirect()->back()
                ->with('error',$exception->getMessage());
        }
    }
}
