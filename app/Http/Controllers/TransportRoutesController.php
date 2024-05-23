<?php

namespace App\Http\Controllers;

use App\Models\Transport;
use App\Models\TransportRoute;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TransportRoutesController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:troute-list|troute-create|troute-edit|troute-delete', ['only' => ['index','store']]);
        $this->middleware('permission:troute-create', ['only' => ['create','store']]);
        $this->middleware('permission:troute-edit', ['only' => ['edit','update']]);
        $this->middleware('permission:troute-delete', ['only' => ['destroy']]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = TransportRoute::latest()->get();
        return view('transport_routes.index', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $transports = Transport::latest()->get();
        return view('transport_routes.create', compact('transports'));
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
                'name' => 'required',
                'vehicles' => 'required'
            ]);

            $routes = TransportRoute::create([ 'name' => $request->name ]);

            $routes->routes_transport()->sync( $request->vehicles );

            DB::commit();
            return redirect()->route('transport-routes.index')
                ->with('success','Transport Route created successfully');
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
        $data = TransportRoute::findOrFail($id);
        $transports = Transport::get();
        $route_transport = DB::table("route_transport")->where("route_transport.transport_route_id",$id)
            ->pluck('route_transport.transport_id','route_transport.transport_id')
            ->all();
        return view('transport_routes.edit', compact('data', 'transports', 'route_transport'));
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
                'name' => 'required',
                'vehicles' => 'required'
            ]);

            $routes = TransportRoute::findOrFail($id);
            $routes->name = $request->name;
            $routes->update();

            $routes->routes_transport()->sync( $request->vehicles );

            DB::commit();
            return redirect()->route('transport-routes.index')
                ->with('success','Transport Route updated successfully');
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

            $routes = TransportRoute::findOrFail($id);
            $routes->delete();

            DB::commit();
            return redirect()->route('transport-routes.index')
                ->with('success','Transport Route deleted successfully');
        }
        catch (\Exception $exception){
            DB::rollBack();
            return redirect()->back()
                ->with('error',$exception->getMessage());
        }
    }
}
