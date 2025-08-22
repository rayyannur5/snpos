<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ApiOvertimeController extends Controller
{
    public function operators(Request $request)
    {
        try {

            $user = $request->user();

            $users = DB::select("select * from users where id = '$user->id' or responsibility = '$user->id'");
            $shifts = DB::select("select * from shifts");
            $outlets = DB::select("select * from outlets where active = 1");

            return response()->json([
                'message' => 'success',
                'data' => [
                    'users' => $users,
                    'shifts' => $shifts,
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


            DB::table('overtimes')->insertGetId([
                'create_by' => $request->user()->id,
                'user_id' => $request->operator,
                'date' => $request->date,
                'shift_id' => $request->shift,
                'outlet_id' => $request->outlet,
                'start_time' => $request->start_time,
                'end_time' => $request->end_time,
                'status' => 'A'
            ]);

            if(auth()->user()->level == 1) {
                DB::rollBack();
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
