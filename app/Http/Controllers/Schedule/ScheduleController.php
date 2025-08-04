<?php

namespace App\Http\Controllers\Schedule;

use App\Http\Controllers\Controller;
use App\Imports\ScheduleImport;
use App\Models\Schedule;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class ScheduleController extends Controller
{
    public function index()
    {
        return view('Schedule.index');
    }

    public function getSchedule(Request $request) {
        $request->validate([
            'start' => 'required',
            'end' => 'required',
        ]);

        $data = DB::select("
            select
                schedules.*,
                s.username,
                o.name outlet,
                shifts.name shift
            from schedules
            join users s on s.id = schedules.user_id
            join outlets o on o.id = schedules.outlet_id
            join shifts on shifts.id = schedules.shift_id
            where date between '$request->start' and '$request->end'
        ");

        return response()->json([
            'success' => true,
            'data' => $data
        ]);
    }

    public function create() {

        $employees = DB::select("select id, username from users where level = 6");
        $outlets = DB::select("select * from outlets where active = 1");

        return view('Schedule.create', compact('employees', 'outlets'));
    }

    public function createCanvasSchedule(Request $request) {
        $start = Carbon::parse($request->start);
        $end = Carbon::parse($request->end);
        $dates = CarbonPeriod::create($start, $end);

        $shifts = DB::select("select * from shifts");
        $schedules = DB::select("
            select
                s.*,
                u.username
            from schedules s
            join users u on s.user_id = u.id
            where s.date between '$request->start' and '$request->end' and s.outlet_id = '$request->outlet'
        ");

        $outlet = DB::select("select * from outlets where id = '$request->outlet'")[0];
        $pivot = [];

        foreach ($dates as $date) {
            $row = [
                'tanggal' => $date->toDateString(),
                'outlet' => $outlet->name,
            ];
            foreach ($shifts as $shift) {
                // Cari apakah ada schedule dengan tanggal dan shift tertentu
                $s = collect($schedules)->first(function ($schedule) use ($date, $shift) {
                    return $schedule->date === $date->toDateString() && $schedule->shift_id == $shift->id;
                });

                $row[$shift->name] = $s ? $s->username : 'Pilih Karyawan';
            }
            $pivot[] = $row;
        }

        return response()->json([
            'success' => true,
            'data' => $pivot
        ]);

    }

    public function importSchedule(Request $request) {
        try {
            DB::beginTransaction();

            $import = new ScheduleImport;

            Excel::import($import, $request->file('file'));

            if(auth()->user()->level == 1) {
                DB::commit();
            } else {
                DB::commit();
            }

            return response()->json([
                'message' => 'success',
                'data' => $import->rows
            ]);
        } catch (\Exception $e) {
            DB::rollBack();

            return response()->json(["message" => $e->getMessage(), "trace" => $e->getTrace()], 500);
        }
    }

    public function saveSchedule(Request $request) {
        try {
            DB::beginTransaction();

            foreach($request['rows'] as $row) {
                $outlet = $row['outlet'];
                $date = $row['tanggal'];

                $check_outlet = DB::table('outlets')->where('name', $outlet)->first();
                if($check_outlet == null){
                    throw new \Exception('Outlet not found');
                }

                $shifts = DB::select("select * from shifts");
                foreach ($shifts as $shift) {

                    $user = $row[$shift->name];
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
