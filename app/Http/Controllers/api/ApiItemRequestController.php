<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\ItemRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ApiItemRequestController extends Controller
{
    public function lists()
    {
        try {

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

            return response()->json([
                'message' => 'success',
                'data' => $data
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(["message" => $e->getMessage(), "trace" => $e->getTrace()], 500);
        }
    }

    public function items_and_outlets(Request $request) {
        try {
            $user = $request->user();

            $items = DB::select("select * from master_items");
            $outlets = DB::select("select * from outlets");

            return response()->json([
                'data' => [
                    'items' => $items,
                    'outlets' => $outlets
                ]
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(["message" => $e->getMessage(), "trace" => $e->getTrace()], 500);
        }
    }

    public function create(Request $request) {
        try {
            DB::beginTransaction();

            $user = $request->user();

            ItemRequest::create([
               'request_by' => $user->id,
               'outlet_id' => $request->outlet_id,
               'item_id' => $request->item_id,
               'qty' => $request->qty,
               'note' => $request->note,
               'status' => 'REQUEST',
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
}
