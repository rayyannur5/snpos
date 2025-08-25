<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\LeaveRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ApiLeaveRequestController extends Controller
{
    public function lists(Request $request)
    {
        try {
            $user = $request->user();

            $data = DB::select("
                select
                    l.id,
                    c.name category_name,
                    l.start_date,
                    l.end_date,
                    l.remarks,
                    l.additional_file,
                    l.status,
                    u.name user_name
                from leave_requests l
                join users u on l.user_id = u.id
                join leave_categories c on c.id = l.category_id
                where created_by = $user->id

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

    public function operators(Request $request) {
        try {

            $user = $request->user();

            $operator = DB::select("select * from users where id = $user->id");
            $categories = DB::select("select * from leave_categories");

            return response()->json([
                'message' => 'success',
                'data' => [
                    'operator' => $operator,
                    'categories' => $categories
                ]
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(["message" => $e->getMessage(), "trace" => $e->getTrace()], 500);
        }
    }

    public function create(Request $request) {
        try {
            $request->validate([
                'start_date' => 'required|date',
                'end_date' => 'required|date',
                'user_id' => 'required|integer',
            ]);

            DB::beginTransaction();

            if ($request->attachment) {
                $fileName = $request->file('attachment')->getClientOriginalName();
                $path = $request->file('attachment')->storeAs('leave_requests', $fileName, 'public');
            }

            $user = $request->user();

            LeaveRequest::create([
                'user_id' => $request->user_id,
                'created_by' => $user->id,
                'category_id' => $request->category_id,
                'status' => 'REQUESTED',
                'start_date' => $request->start_date,
                'end_date' => $request->end_date,
                'remarks' => $request->remarks,
                'additional_file' => $path ?? null,
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
