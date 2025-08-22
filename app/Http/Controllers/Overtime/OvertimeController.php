<?php

namespace App\Http\Controllers\Overtime;

use App\Http\Controllers\Controller;
use App\Models\Overtime;
use App\Models\Schedule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OvertimeController extends Controller
{
    public function index()
    {
        $pendings = DB::select("
            select
                o.id,
                o.date Tanggal,
                c.name DibuatOleh,
                u.name Operator,
                s.name Shift,
                oo.name Outlet,
                a.name Area
            from overtimes o
                join users c on c.id = o.create_by
                join users u on u.id = o.user_id
                join shifts s on s.id = o.shift_id
                join outlets oo on oo.id = o.outlet_id
                join areas a on a.id = oo.area_id
            where o.status = 'A'
        ");

        return view('Overtime.index', compact('pendings'));
    }

    public function approve(Request $request) {
        try {
            DB::beginTransaction();

            $data = DB::select("select * from overtimes where id = '$request->id'")[0];

            Schedule::create([
                'outlet_id' => $data->outlet_id,
                'shift_id' => $data->shift_id,
                'date' => $data->date,
                'user_id' => $data->user_id,
                'overtime_id' => $data->id,
            ]);

            Overtime::find($data->id)->update([
                'status' => 'P',
                'post_date' => now(),
                'approved_by' => auth()->id()
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

    public function reject(Request $request) {
        try {
            DB::beginTransaction();


            Overtime::find($request->id)->update([
                'status' => 'R',
                'post_date' => now(),
                'rejected_by' => auth()->id(),
                'rejected_note' => $request->rejected_note,
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

    public function information() {

        $approved = DB::select("
            select
                o.id,
                o.date Tanggal,
                c.name DibuatOleh,
                u.name Operator,
                s.name Shift,
                oo.name Outlet,
                a.name Area,
                aa.check_in_time,
                aa.check_out_time
            from overtimes o
                join users c on c.id = o.create_by
                join users u on u.id = o.user_id
                join shifts s on s.id = o.shift_id
                join outlets oo on oo.id = o.outlet_id
                join areas a on a.id = oo.area_id
                join schedules ss on ss.overtime_id = o.id
                left join attendances aa on aa.schedule_id = ss.id
            where o.status = 'P'
        ");

        $rejected = DB::select("
            select
                o.id,
                o.date Tanggal,
                c.name DibuatOleh,
                u.name Operator,
                s.name Shift,
                oo.name Outlet,
                a.name Area
            from overtimes o
                join users c on c.id = o.create_by
                join users u on u.id = o.user_id
                join shifts s on s.id = o.shift_id
                join outlets oo on oo.id = o.outlet_id
                join areas a on a.id = oo.area_id
            where o.status = 'R'
        ");

        return view('Overtime.information', compact('approved', 'rejected'));
    }
}
