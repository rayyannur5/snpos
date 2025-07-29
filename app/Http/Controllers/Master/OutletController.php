<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use App\Models\Outlet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OutletController extends Controller
{
    public function index()
    {

        $data = DB::select("
            select
                o.*,
                a.name as area_name
            from outlets o
            join areas a on a.id = o.area_id
        ");

        $areas = DB::select("select * from areas where active = 1");

        return view('Master.Outlet.index', compact('data', 'areas'));
    }

    public function create(Request $request) {
        try {
            DB::beginTransaction();

            Outlet::create([
               'name' => $request->name,
               'area_id' => $request->area,
               'description' => $request->description,
               'latitude' => $request->latitude,
               'longitude' => $request->longitude,
               'active' => 1,
            ]);


            if(auth()->user()->level == 1) {
                DB::commit();
            } else {
                DB::commit();
            }
            return response()->json([
                'message' => 'success'
            ]);
        } catch (\Exception $e) {
            DB::rollBack();

            return response()->json(["message" => $e->getMessage(), "trace" => $e->getTrace()], 500);
        }
    }

    public function update(Request $request) {
        try {
            DB::beginTransaction();


            Outlet::find($request->id)->update([
                'name' => $request->name,
                'area_id' => $request->area,
                'description' => $request->description,
                'latitude' => $request->latitude,
                'longitude' => $request->longitude,
                'active' => $request->active,
            ]);


            if(auth()->user()->level == 1) {
                DB::commit();
            } else {
                DB::commit();
            }
            return response()->json([
                'message' => 'success'
            ]);
        } catch (\Exception $e) {
            DB::rollBack();

            return response()->json(["message" => $e->getMessage(), "trace" => $e->getTrace()], 500);
        }
    }
}
