<?php

namespace App\Http\Controllers\Overtime;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class OvertimeController extends Controller
{
    public function index()
    {
        $pendings = DB::select("
            select
                o.id,
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
}
