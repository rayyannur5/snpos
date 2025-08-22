<?php

namespace App\Http\Controllers\MaintenanceRequest;

use App\Http\Controllers\Controller;
use App\Models\MaintenanceRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MaintenanceRequestController extends Controller
{
    public function index()
    {

        $pendings = DB::select("
            select
                r.id,
                r.note,
                m.name Barang,
                o.name Outlet,
                u.name DimintaOleh,
                uu.name DikerjakanOleh,
                uuu.name DiverifikasiOleh,
                r.request_picture,
                r.approved_picture,
                r.request_date TanggalPermintaan,
                r.accepted_date TanggalDibagikan,
                r.started_date TanggalDikerjakan,
                r.approved_date TanggalVerifikasi,
                case
                    when r.accepted_date is null then 'Belum Dibagikan'
                    when r.started_date is null then 'Belum Dikerjakan'
                    when r.approved_date is null then 'Sedang Dikerjakan'
                    else 'Sudah Diverifikasi'
                    end as Status,
                r.active
            from maintenance_requests r
                     join master_items m on r.item_id = m.id
                     join outlets o on r.outlet_id = o.id
                     join users u on r.request_by = u.id
                     left join users uu on r.user_to = uu.id
                     left join users uuu on r.approved_by = uuu.id
            order by r.request_date desc
        ");

        $users = DB::select("select * from users");

        return view('MaintenanceRequest.index', compact('pendings', 'users'));
    }

    public function share(Request $request)
    {
        try {
            $validated = $request->validate([
                'id' => 'required',
                'user' => 'required',
            ]);

            DB::beginTransaction();

            MaintenanceRequest::find($validated['id'])->update([
                'accepted_by' => auth()->id(),
                'accepted_date' => now(),
                'user_to' => $validated['user'],
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
