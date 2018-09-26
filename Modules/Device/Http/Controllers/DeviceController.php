<?php

namespace Modules\Device\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\Device\Entities\Device;
use Yajra\Datatables\Datatables;

class DeviceController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index()
    {
        return view('device::index');
    }

    /**
     * Show the form for creating a new resource.
     * @return Response
     */
    public function create()
    {
        return view('device::create');
    }

    /**
     * Store a newly created resource in storage.
     * @param  Request $request
     * @return Response
     */
    public function store(Request $request)
    {
        $device = new Device();
        $device->name = $request->name;
        $device->ip_address = $request->ip_address;
        $device->description = $request->description;
        $device->password = $request->password;
        $device->is_online = ($request->is_online == 1) ? 1 : 0;
        $device->save();

        return redirect()->back();
    }

    /**
     * Show the specified resource.
     * @return Response
     */
    public function show()
    {
        return view('device::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @return Response
     */
    public function edit()
    {
        return view('device::edit');
    }

    /**
     * Update the specified resource in storage.
     * @param  Request $request
     * @return Response
     */
    public function update(Request $request)
    {
    }

    /**
     * Remove the specified resource from storage.
     * @return Response
     */
    public function destroy(Request $request)
    {
        $device = Device::find($request->id_delete);
        $device->delete();

        return redirect()->back();
    }

    public function DatatableListDevice() {

        return Datatables::of(Device::query())
            ->make(true);

    }
}
