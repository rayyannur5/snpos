<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Http\Helpers\PublicFunctions;
use App\Models\Transaction;
use App\Models\TransactionItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ApiTransactionController extends Controller
{
    public function products(Request $request)
    {
        $user = PublicFunctions::userStatus($request->user()->id);

        $products = DB::select("
            select
                p.id,
                p.name,
                po.price,
                case
                    when p.name like '%motor%' then 'Motor'
                    when p.name like '%mobil%' then 'Mobil'
                    else ''
                end as type
            from product_outlets po
            join products p on p.id = po.product_id
            where po.outlet_id = $user->outlet_id
        ");

        return response()->json([
            'data' => $products
        ]);

    }

    public function payments(Request $request) {
        $data = DB::select("select * from payments where active = 1");
        $cash_units = DB::select("select * from cash_units");
        $shortcut_remarks = DB::select("select * from shortcut_remarks where module = 'Mobile'");
        return response()->json([
            'data' => [
                'payments' => $data,
                'cash_units' => $cash_units,
                'shortcut_remarks' => $shortcut_remarks
            ]
        ]);
    }

    public function create(Request $request) {
        try {
            $request->validate([
                'transaction' => 'required',
                'items' => 'required'
            ]);

            DB::beginTransaction();

            $user = PublicFunctions::userStatus($request->user()->id);


            if($user->is_absen != 'Y') {
                throw new \Exception('Operator/Karyawan belum absen');
            }

            if($request->file('photo')) {
                $filename = $request->file('photo')->getClientOriginalName();
                $path = $request->file('photo')->storeAs('transaction_photos', $filename,'public');
            }

            $header = json_decode($request->transaction, true);
            $transaction_items = json_decode($request->items, true);

            $transaction = Transaction::create([
                'user_id'        => $user->id,
                'attendance_id'  => $user->attendance_id,
                'code'           => $header['code'],
                'date'           => $header['date'],
                'sell'           => $header['sell'],
                'pay'            => $header['pay'],
                'payment_method' => $header['payment_method'],
                'remarks'        => $header['remarks'],
                'active'         => 1,
                'photo'          => $path ?? null,
            ]);

            $ordinal = 1;
            foreach ($transaction_items as $item) {
                for($i = 0; $i < $item['qty']; $i++) {
                    $items[] = TransactionItem::create([
                        'code_id'    => $item['code_id'],
                        'ordinal'    => $ordinal,
                        'product_id' => $item['product_id'],
                        'qty'        => 1,
                        'price'      => $item['price'],
                    ]);
                    $ordinal++;
                }
            }

            if(auth()->user()->level == 1) {
                DB::commit();
            } else {
                DB::commit();
            }
            return response()->json([
                'message' => 'success',
                'data' => [
                    'transaction' => $transaction,
                    'items' => $items ?? []
                ]
            ], 201);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(["message" => $e->getMessage(), "trace" => $e->getTrace()], 500);
        }
    }
}
