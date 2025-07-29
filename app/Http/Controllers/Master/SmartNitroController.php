<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use App\Models\SmartNitro;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SmartNitroController extends Controller
{
    public function index()
    {
        $data = DB::select("
            select
                s.*,
                o.name outlet
            from smart_nitros s
            join outlets o on s.outlet_id = o.id
        ");

        $outlets = DB::select("select * from outlets where active = 1");

        return view('Master.SmartNitro.index', compact('data', 'outlets'));
    }

    public function create(Request $request) {
        try {
            DB::beginTransaction();

            SmartNitro::create([
                'id' => $request->id_smart_nitro,
                'outlet_id' => $request->outlet_id
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


            SmartNitro::find($request->id)->update([
                'id' => $request->id_smart_nitro,
                'outlet_id' => $request->outlet_id
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
