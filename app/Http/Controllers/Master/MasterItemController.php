<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use App\Models\MasterItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MasterItemController extends Controller
{
    public function index()
    {

        $data = DB::select("
            select
                *,
                case when type = 'TOOL' then 'Alat' else 'Bahan' end as type,
                type original_type
            from master_items
        ");

        return view('Master.Item.index', compact('data'));
    }

    public function create(Request $request) {
        try {
            DB::beginTransaction();

            MasterItem::create([
                'name' => $request->name,
                'description' => $request->description,
                'type' => $request->type,
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

            MasterItem::find($request->id)->update([
                'name' => $request->name,
                'description' => $request->description,
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
