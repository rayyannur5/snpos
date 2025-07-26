<?php

namespace App\Http\Controllers\UserRoles;

use App\Http\Controllers\Controller;
use App\Models\Module;
use App\Models\ModuleLevel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ModuleController extends Controller
{
    public function index()
    {
        $data = DB::select("
            select
                modules.id,
                modules.name,
                modules.ordinal,
                m.name as parent,
                modules.parent parent_id,
                modules.path,
                modules.status,
                modules.icon,
                modules.created_at,
                modules.updated_at,
                group_concat(l.name) as access,
                group_concat(l.id) as access_id
            from modules
            left join modules m on m.id = modules.parent
            left join module_levels ml on ml.module_id = modules.id
            left join levels l on l.id = ml.level_id
            group by modules.id
        ");

        $levels = DB::select("select * from levels where active = 1");

        return view('User&Roles.Modules.index', compact('data', 'levels'));
    }

    public function create(Request $request) {
        try {
            DB::beginTransaction();

            $parent = $request->parent ?? 0;

            $module = Module::create([
                'name' => $request->name,
                'ordinal' => DB::select("select max(ordinal) + 1 as max from modules where parent = $parent")[0]->max ?? 1,
                'parent' => $parent,
                'path' => $request->path,
                'status' => $request->status,
                'icon' => $request->icon,
            ]);

            if($request->access) {
                foreach ($request->access as $access) {
                    ModuleLevel::create([
                        'module_id' => $module->id,
                        'level_id' => $access,
                    ]);
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

    public function update(Request $request) {
        try {
            DB::beginTransaction();

            $module = Module::find($request->id);

            $module->update([
                'name' => $request->name,
                'icon' => $request->icon,
                'parent' => $request->parent ?? 0,
                'status' => $request->status,
                'path' => $request->path,
            ]);

            ModuleLevel::where('module_id', $module->id)->delete();

            if($request->access) {
                foreach ($request->access as $access) {
                    $check = ModuleLevel::where('module_id', $module->id)->where('level_id', $access)->exists();
                    if(!$check) {
                        ModuleLevel::create([
                            'module_id' => $module->id,
                            'level_id' => $access,
                        ]);
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
