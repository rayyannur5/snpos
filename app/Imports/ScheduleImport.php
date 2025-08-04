<?php

namespace App\Imports;

use App\Models\Schedule;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class ScheduleImport implements ToCollection, WithHeadingRow
{
    public Collection $rows;

    /**
    * @param Collection $collection
    */
    public function collection(Collection $collection)
    {
        $this->rows = $collection;

        foreach ($collection as $row) {
            $outlet = $row['outlet'];
            $date = $row['tanggal'];

            $check_outlet = DB::table('outlets')->where('name', $outlet)->first();
            if($check_outlet == null){
                throw new \Exception('Outlet not found');
            }

            $shifts = DB::select("select * from shifts");
            foreach ($shifts as $shift) {

                $user = $row[strtolower(str_replace(' ', '_', $shift->name))];
                $user = DB::table('users')->where('username', $user)->first();

                $exists = DB::table("schedules")->where('outlet_id', $check_outlet->id)->where('shift_id', $shift->id)->where('date', $date)->exists();

                if($user) {
                    if($exists) {
                        Schedule::where('outlet_id', $check_outlet->id)->where('shift_id', $shift->id)->where('date', $date)->update([
                            'user_id' => $user->id
                        ]);
                    } else {
                        Schedule::create([
                            'outlet_id' => $check_outlet->id,
                            'shift_id' => $shift->id,
                            'date' => $date,
                            'user_id' => $user->id,
                        ]);
                    }
                }
            }
        }
    }
}
