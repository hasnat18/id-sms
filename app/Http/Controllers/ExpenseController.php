<?php

namespace App\Http\Controllers;

use App\Models\Expense;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ExpenseController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:expense-list|expense-create|expense-edit|expense-delete', ['only' => ['index','store']]);
        $this->middleware('permission:expense-create', ['only' => ['create','store']]);
        $this->middleware('permission:expense-edit', ['only' => ['edit','update']]);
        $this->middleware('permission:expense-delete', ['only' => ['destroy']]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = Expense::latest()->get();
        return view('expenses.index', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('expenses.create');
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
                'expense' => 'required', 'note' => 'nullable'
            ]);

            Expense::create([
                'expense' => $request->expense, 'note' => $request->note,'date' =>$request->date, 'user_id' => auth()->user()->id
            ]);

            DB::commit();
            return redirect()->route('expenses.index')
                ->with('success','Expense saved successfully');
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
        $data = Expense::findOrFail($id);
        return view('expenses.edit', compact('data'));
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
                'expense' => 'required', 'note' => 'nullable'
            ]);

            Expense::where('id', $id)->update([
                'expense' => $request->expense, 'note' => $request->note, 'user_id' => auth()->user()->id
            ]);

            DB::commit();
            return redirect()->route('expenses.index')
                ->with('success','Expense updated successfully');
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
            Expense::find($id)->delete();
            DB::commit();
            return redirect()->route('expenses.index')
                ->with('success','Expense deleted successfully');
        }
        catch (\Exception $exception){
            DB::rollBack();
            return redirect()->back()
                ->with('error',$exception->getMessage());
        }
    }
}
