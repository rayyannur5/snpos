<?php

namespace App\Http\Controllers\LeaveRequest;

use App\Http\Controllers\Controller;
use App\Models\LeaveRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class LeaveRequestController extends Controller
{
    public function index()
    {

        $data = DB::select("
                select
                    l.id,
                    c.name category_name,
                    l.start_date,
                    l.end_date,
                    l.remarks,
                    l.additional_file,
                    l.status,
                    u.name user_name,
                    l.created_at
                from leave_requests l
                join users u on l.user_id = u.id
                join leave_categories c on c.id = l.category_id
                order by created_at desc
            ");


        return view('LeaveRequest.index', compact('data'));
    }

    public function update(Request $request) {
        try {
            DB::beginTransaction();

            LeaveRequest::find($request->id)->update([
                'status' => $request->status,
                'updated_by' => auth()->id(),
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
