<?php

namespace App\Http\Helpers;

use Illuminate\Support\Facades\DB;

class PublicFunctions
{
    public static function userStatus($user_id) {
        $data = collect(DB::select("
            select
                u.*,
                case
                    when a.check_out_time is not null then 'X'
                    when a.check_in_time is not null then 'Y'
                    else 'N' end as is_absen,
                a.id attendance_id,
                a.check_in_time,
                c.name shift_name,
                o.name outlet_name,
                o.id outlet_id
            from users u
            left join attendances a on a.user_id = u.id and date(a.created_at) = current_date()
            left join schedules s on a.schedule_id = s.id
            left join shifts c on s.shift_id = c.id
            left join outlets o on s.outlet_id = o.id
            where u.id = $user_id
        "))->first();

        return $data;
    }
}
