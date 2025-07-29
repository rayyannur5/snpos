<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use App\Models\Area;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AreaController extends Controller
{
    public function index()
    {

        $data = DB::select("select * from areas");

        return view('Master.Area.index', compact('data'));
    }

    public function create(Request $request) {
        try {
            DB::beginTransaction();

            Area::create([
                'user_id' => auth()->id(),
                'name' => $request->name,
                'active' => 1
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

            Area::find($request->id)->update([
                'name' => $request->name,
                'active' => $request->active
            ]);

            if(auth()->user()->level == 1) {
                DB::commit();
            } else {
                DB::commit();
                return response()->json([
                    'message' => 'success'
                ]);
            }
        } catch (\Exception $e) {
            DB::rollBack();

            return response()->json(["message" => $e->getMessage(), "trace" => $e->getTrace()], 500);
        }
    }
}
