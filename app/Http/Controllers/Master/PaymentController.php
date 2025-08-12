<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PaymentController extends Controller
{
    public function index()
    {

        $data = Payment::all();

        return view('Master.Payment.index', compact('data'));
    }

    public function create(Request $request) {
        try {
            DB::beginTransaction();

            Payment::create([
                'name' => $request->name,
                'is_fully_paid' => isset($request->is_fully_paid) ? 1 : 0,
                'is_need_picture' => isset($request->is_need_picture) ? 1 : 0,
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

    public function update(Request $request) {
        try {
            DB::beginTransaction();

            Payment::find($request->id)->update([
                'name' => $request->name,
                'is_fully_paid' => isset($request->is_fully_paid) ? 1 : 0,
                'is_need_picture' => isset($request->is_need_picture) ? 1 : 0,
                'active' => $request->active
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
