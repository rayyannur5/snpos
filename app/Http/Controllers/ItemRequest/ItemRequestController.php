<?php

namespace App\Http\Controllers\ItemRequest;

use App\Http\Controllers\Controller;
use App\Models\ItemRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ItemRequestController extends Controller
{
    public function index()
    {

        $data = DB::select("
            select
                i.*,
                u.name request_name,
                o.name outlet_name,
                m.name item_name
            from item_requests i
            join users u on u.id = i.request_by
            join outlets o on o.id = i.outlet_id
            join master_items m on m.id = i.item_id
        ");

        return view('ItemRequest.index', compact('data'));
    }

    public function update(Request $request) {
        try {
            DB::beginTransaction();

            ItemRequest::find($request->id)->update([
                'status' => $request->status,
                'approved_by' => auth()->id(),
                'approved_date' => now(),
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
