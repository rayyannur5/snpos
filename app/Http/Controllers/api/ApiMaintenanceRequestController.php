<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Http\Helpers\PublicFunctions;
use App\Models\MaintenanceRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ApiMaintenanceRequestController extends Controller
{
    public function lists(Request $request)
    {
        try {

            $user = $request->user();

            $data = DB::select("
                select
                    r.id,
                    r.note,
                    r.request_date,
                    r.request_by,
                    r.user_to,
                    m.name item_name,
                    o.name outlet_name,
                    u.name request_name,
                    uu.name maintenance_name,
                    r.request_picture,
                    r.approved_picture,
                    r.started_date,
                    r.accepted_date,
                    r.approved_date,
                    case
                        when r.accepted_date is null then 'Belum Dibagikan'
                        when r.started_date is null then 'Belum Dikerjakan'
                        when r.approved_date is null then 'Sedang Dikerjakan'
                        else 'Sudah Diverifikasi'
                    end as status
                from maintenance_requests r
                join master_items m on r.item_id = m.id
                join outlets o on r.outlet_id = o.id
                join users u on r.request_by = u.id
                left join users uu on r.user_to = uu.id
                where (r.request_by = $user->id or r.user_to = $user->id)
                order by r.request_date desc
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


    public function items_and_outlets(Request $request)
    {
        try {
            $user = $request->user();

            $items = DB::select("select * from master_items where type = 'TOOL'");
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

    public function create(Request $request)
    {
        try {

            $validated = $request->validate([
                'item_id' => 'required',
                'outlet_id' => 'required',
                'note' => 'required',
                'image' => 'image|mimes:jpg,jpeg,png|max:2048',
            ]);


            DB::beginTransaction();

            $user = $request->user();


            if ($request->hasFile('image')) {
                $fileName = $request->file('image')->getClientOriginalName();
                $path = $request->file('image')->storeAs('maintenance_request_photos', $fileName, 'public');
            } else {
                $path = null;
            }

            MaintenanceRequest::create([
                'request_by' => $user->id,
                'item_id' => $request->item_id,
                'outlet_id' => $request->outlet_id,
                'note' => $request->note,
                'request_date' => now(),
                'request_picture' => $path,
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

    public function assign(Request $request){
        try {

            DB::beginTransaction();

            MaintenanceRequest::find($request->id)->update([
                'started_date' => now(),
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

    public function approve(Request $request){
        try {
            $request->validate([
                'id' => 'required',
                'approved_picture' => 'required|image|mimes:jpg,jpeg,png|max:2048',
            ]);

            DB::beginTransaction();

            $user = $request->user();

            $fileName = $request->file('approved_picture')->getClientOriginalName();
            $path = $request->file('approved_picture')->storeAs('maintenance_approved_photos', $fileName, 'public');

            MaintenanceRequest::find($request->id)->update([
                'approved_date' => now(),
                'approved_by' => $user->id,
                'approved_picture' => $path,
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
