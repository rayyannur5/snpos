<?php

namespace App\Http\Controllers\UserRoles;

use App\Http\Controllers\Controller;
use App\Models\Level;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class LevelController extends Controller
{
    public function index()
    {
        $data = DB::select("select * from levels");
        return view('User&Roles.Levels.index', compact('data'));
    }

    public function create(Request $request) {
        try {
            DB::beginTransaction();

            Level::create([
                'name' => $request->name,
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

            Level::find($request->id)->update([
                'name' => $request->name,
                'active' => $request->active,
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
