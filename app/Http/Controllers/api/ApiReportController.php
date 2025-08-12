<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ApiReportController extends Controller
{

    public function sales_report(Request $request) {
        try {

            $user = $request->user();
            $start_date = $request->start_date;
            $end_date = $request->end_date;


            $data = DB::select("
                select
                    t.code,
                    t.date,
                    t.sell,
                    t.pay,
                    o.name outlet
                from transactions t
                join attendances a on a.id = t.attendance_id
                join schedules s on s.id = a.schedule_id
                join outlets o on o.id = s.outlet_id
                where date(t.date) between '$start_date' and '$end_date' and t.user_id = $user->id
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

    public function summary_sales_report(Request $request) {

        try {
            $user = $request->user();

            $start_date = $request->start_date;
            $end_date = $request->end_date;

            $data = DB::select("
                select
                    count(*) as total,
                    sum(sell) as omset
                from transactions
                where date(date) between '$start_date' and '$end_date' and user_id = $user->id
            ")[0];

            return response()->json([
                'data' => $data
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(["message" => $e->getMessage(), "trace" => $e->getTrace()], 500);
        }

    }

    public function attendance_report(Request $request) {
        try {

            $user = $request->user();
            $start_date = $request->start_date;
            $end_date = $request->end_date;

            $data = DB::select("
                select
                    a.id,
                    if(time(a.check_in_time) > f.start_time, 1, 0) is_late,
                    o.name outlet,
                    f.name shift,
                    a.check_in_time date_in,
                    a.check_out_time date_out,
                    ifnull(sum(t.sell), 0) omset,
                    if(t.deposit_id is not null, 1, 0) is_deposit
                from attendances a
                join schedules s on s.id = a.schedule_id
                join shifts f on f.id = s.shift_id
                join outlets o on o.id = s.outlet_id
                left join transactions t on t.attendance_id = a.id
                where date(a.check_in_time) between '$start_date' and '$end_date' and a.user_id = $user->id
                group by a.id
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

    public function summary_attendance_report(Request $request) {
        try {
            $user = $request->user();
            $start_date = $request->start_date;
            $end_date = $request->end_date;


            $data = DB::select("
                select
                    sum(if(time(a.check_in_time) <= f.start_time, 1, 0)) ontime,
                    sum(if(time(a.check_in_time) > f.start_time, 1, 0)) late
                from attendances a
                join schedules s on s.id = a.schedule_id
                join shifts f on f.id = s.shift_id
                where date(a.check_in_time) between '$start_date' and '$end_date' and a.user_id = $user->id
            ")[0];


            return response()->json([
                'message' => 'success',
                'data' => $data
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(["message" => $e->getMessage(), "trace" => $e->getTrace()], 500);
        }
    }

    public function deposit_report(Request $request) {
        try {
            $user = $request->user();
            $start_date = $request->start_date;
            $end_date = $request->end_date;

            $data = DB::select("
                select
                    d.amount omset,
                    d.created_at date,
                    group_concat(distinct o.name) outlet
                from deposits d
                join transactions t on t.deposit_id = d.id
                join attendances a on a.id = t.attendance_id
                join schedules s on s.id = a.schedule_id
                join outlets o on o.id = s.outlet_id
                where date(d.created_at) between '$start_date' and '$end_date' and d.user_id = $user->id
                group by d.id
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

    public function summary_deposit_report(Request $request) {
        try {
            $user = $request->user();
            $start_date = $request->start_date;
            $end_date = $request->end_date;

            $data = DB::select("
                select
                    ifnull(sum(sell), 0) tabungan
                from transactions
                where user_id = $user->id and deposit_id is null
            ")[0];


            return response()->json([
                'message' => 'success',
                'data' => $data
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(["message" => $e->getMessage(), "trace" => $e->getTrace()], 500);
        }
    }

    public function schedules(Request $request)
    {
        try {

            $user = $request->user();
            $start_date = $request->start_date;
            $end_date = $request->end_date;

            $data = DB::select("
                select
                    a.date,
                    s.name shift,
                    b.name outlet,
                    case
                        when time(c.check_in_time) > s.start_time then 2
                        when time(c.check_in_time) <= s.start_time then 1
                        else 0
                    end as status
                from schedules a
                join shifts s on a.shift_id = s.id
                join outlets b on a.outlet_id = b.id
                left join attendances c on c.schedule_id = a.id
                where a.user_id = $user->id and a.date between '$start_date' and '$end_date'
            ");

            return response()->json([
                'data' => $data
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(["message" => $e->getMessage(), "trace" => $e->getTrace()], 500);
        }

    }

}
