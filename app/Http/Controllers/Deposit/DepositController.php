<?php

namespace App\Http\Controllers\Deposit;

use App\Http\Controllers\Controller;
use App\Models\Deposit;
use Illuminate\Support\Facades\DB;

class DepositController extends Controller
{
    public function index()
    {

        $pendings = collect(DB::select("
            select
                d.id,
                d.amount Omset,
                d.created_at Tanggal,
                u.name Operator,
                count(t.id) TotalTransaksi,
                group_concat(distinct o.name) Outlet
            from deposits d
            join transactions t on t.deposit_id = d.id
            join attendances a on a.id = t.attendance_id
            join schedules s on s.id = a.schedule_id
            join outlets o on o.id = s.outlet_id
            join users u on u.id = d.user_id
            where d.post_date is null
            group by d.id
        "));

        return view('Deposit.TerimaSetoran.index', compact('pendings'));
    }

    public function detail($id) {
        $data = DB::select("
            select
                d.id,
                d.amount Omset,
                d.created_at Tanggal,
                u.name Operator,
                count(t.id) TotalTransaksi,
                group_concat(distinct o.name) Outlet
            from deposits d
            join transactions t on t.deposit_id = d.id
            join attendances a on a.id = t.attendance_id
            join schedules s on s.id = a.schedule_id
            join outlets o on o.id = s.outlet_id
            join users u on u.id = d.user_id
            where d.id = $id
            group by d.id
        ")[0];
        $data->items = DB::select("
            select
                i.code_id,
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
            where t.deposit_id = $id
            group by i.code_id, i.product_id
        ");

        return response()->json([
            'data' => $data
        ]);
    }


    public function verify($id) {
        try {

            DB::beginTransaction();

            Deposit::find($id)->update(['post_date' => now(), 'post_by' => auth()->id()]);


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
