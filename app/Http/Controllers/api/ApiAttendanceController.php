<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Http\Helpers\PublicFunctions;
use App\Models\Attendance;
use App\Models\Deposit;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ApiAttendanceController extends Controller
{
    public function attendance(Request $request) {

        $user = $request->user();

        $data = PublicFunctions::userStatus($user->id);

        return response()->json([
            'data' => $data,
        ]);
    }

    public function attendance_today(Request $request) {
        $user = $request->user();

        $data = DB::select("
            select
                a.id,
                case when time(a.check_in_time) > f.start_time then 1 else 0 end is_late,
                a.check_in_time,
                a.check_out_time,
                f.name shift_name,
                o.name outlet_name,
                sum(t.sell) omset,
                case when d.id is not null then 1 else 0 end is_deposit
            from attendances a
            join schedules s on s.id = a.schedule_id
            join shifts f on f.id = s.shift_id
            join outlets o on o.id = s.outlet_id
            left join transactions t on t.attendance_id = a.id
            left join deposits d on d.id = t.deposit_id
            where a.user_id = $user->id and date(a.created_at) = current_date()
            group by a.id
        ");

        return response()->json([
            'data' => $data,
        ]);
    }

    public function schedule(Request $request)
    {
        $user = $request->user();

        $data = collect(DB::select("
            select
                a.id,
                a.date,
                s.name shift_name,
                b.name outlet_name
            from schedules a
            join shifts s on a.shift_id = s.id
            join outlets b on a.outlet_id = b.id
            where a.user_id = $user->id and a.date = current_date()
        "))->first();

        return response()->json([
            'data' => $data
        ]);
    }

    public function create(Request $request) {
        try {

            $validated = $request->validate([
                'scheduleId'  => 'required|integer',
                'latitude'      => 'required|numeric',
                'longitude'     => 'required|numeric',
                'namedLocation' => 'required|string|max:255',
                'photo'         => 'required|image|mimes:jpg,jpeg,png|max:2048',
            ]);

            $user = $request->user();

            DB::beginTransaction();

            $attendance = Attendance::create([
                'user_id'           => $user->id,
                'schedule_id'       => $validated['scheduleId'],
                'check_in_latitude' => $validated['latitude'],
                'check_in_longitude'=> $validated['longitude'],
                'check_in_location' => $validated['namedLocation'],
                'check_in_time'     => now(),
                'check_in_picture'  => null,
            ]);


            $extension = $request->file('photo')->getClientOriginalExtension();
            $timestamp = now()->format('Ymd_His');
            $fileName = "{$attendance->id}_{$timestamp}.{$extension}";

            $path = $request->file('photo')->storeAs('attendance_photos', $fileName, 'public');

            $attendance->update([
                'check_in_picture' => $path,
            ]);

            if($user->level == 1) {
                DB::commit();
            } else {
                DB::commit();
            }

            $data = PublicFunctions::userStatus($user->id);

            return response()->json([
                'message' => 'success',
                'data' => $data,
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(["message" => $e->getMessage(), "trace" => $e->getTrace()], 500);
        }
    }

    public function exit(Request $request) {
        try {

            $validated = $request->validate([
                'attendanceId'  => 'required|integer',
                'latitude'      => 'required|numeric',
                'longitude'     => 'required|numeric',
                'namedLocation' => 'required|string|max:255',
                'photo'         => 'required|image|mimes:jpg,jpeg,png|max:2048',
            ]);

            $user = $request->user();

            DB::beginTransaction();

            $attendance = Attendance::find($validated['attendanceId']);

            $attendance->update([
                'check_out_latitude'  => $validated['latitude'],
                'check_out_longitude' => $validated['longitude'],
                'check_out_location'  => $validated['namedLocation'],
                'check_out_time'      => now(),
                'check_out_picture'   => null,
            ]);


            $extension = $request->file('photo')->getClientOriginalExtension();
            $timestamp = now()->format('Ymd_His');
            $fileName = "{$attendance->id}_{$timestamp}.{$extension}";

            $path = $request->file('photo')->storeAs('attendance_photos', $fileName, 'public');

            $attendance->update([
                'check_out_picture' => $path,
            ]);

            if($user->level == 1) {
                DB::commit();
            } else {
                DB::commit();
            }

            $data = PublicFunctions::userStatus($user->id);

            return response()->json([
                'message' => 'success',
                'data' => $data,
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(["message" => $e->getMessage(), "trace" => $e->getTrace()], 500);
        }
    }

    public function summary_transaction_not_deposit_yet(Request $request) {
        $user = $request->user();

        $total_amount = collect(DB::select("select sum(sell) amount from transactions where deposit_id is null and user_id = $user->id"))->first()->amount;
        $transactions = DB::select("
            select
                i.product_id,
                p.name product_name,
                sum(i.qty) qty,
                i.price,
                sum(i.price) total_amount
            from transactions t
            join transaction_items i on i.code_id = t.code
            join attendances a on a.id = t.attendance_id
            join schedules s on s.id = a.schedule_id
            join products p on p.id = i.product_id
            join product_outlets po on po.product_id = p.id and po.outlet_id = s.outlet_id
            where t.deposit_id is null and t.user_id = $user->id
            group by p.id
        ");

        return response()->json([
            'data' => [
                'total_amount' => $total_amount,
                'transactions' => $transactions,
            ],
        ]);

    }


    public function deposit(Request $request) {

        try {
            DB::beginTransaction();

            $user = $request->user();

            $total_amount = collect(DB::select("select sum(sell) amount from transactions where deposit_id is null and user_id = $user->id"))->first()->amount;

            $deposit = Deposit::create([
                'user_id' => $user->id,
                'amount' => $total_amount,
                'remarks' => $request->remarks,
            ]);

            Transaction::where('deposit_id', null)->where('user_id', $user->id)->update([
                'deposit_id' => $deposit->id,
            ]);

            if(auth()->user()->level == 1) {
                DB::commit();
            } else {
                DB::commit();
            }

            return response()->json([
                'message' => 'success',
                'data' => $request->remarks,
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(["message" => $e->getMessage(), "trace" => $e->getTrace()], 500);
        }


    }

    public function detail_attendance(Request $request, $id) {
        $user = $request->user();

        $total_amount = collect(DB::select("
            select
                sum(t.sell) amount
            from transactions t
            join attendances a on a.id = t.attendance_id
            where t.user_id = $user->id and a.id = $id
        "))->first()->amount;

        $transactions = DB::select("
            select
                i.product_id,
                p.name product_name,
                sum(i.qty) qty,
                i.price,
                sum(i.price) total_amount
            from transactions t
            join transaction_items i on i.code_id = t.code
            join attendances a on a.id = t.attendance_id
            join schedules s on s.id = a.schedule_id
            join products p on p.id = i.product_id
            join product_outlets po on po.product_id = p.id and po.outlet_id = s.outlet_id
            where t.user_id = $user->id and a.id = $id
            group by p.id
        ");

        return response()->json([
            'data' => [
                'total_amount' => $total_amount,
                'transactions' => $transactions,
            ]
        ]);

    }
}
