<?php

namespace App\Http\Controllers\UserRoles;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index()
    {
        $data = DB::select("
            select
                users.id ID,
                users.name Name,
                users.username Username,
                users.email Email,
                levels.name Level,
                levels.id IDLevel,
                users.active Active,
                users.created_at Created,
                users.updated_at Updated
            from users
            join levels on levels.id = users.level
        ");

        $levels = DB::select("select * from levels");

        return view('User&Roles.Users.index', compact('data', 'levels'));
    }

    public function create(Request $request) {
        try {
            DB::beginTransaction();

            $check = User::where('username', $request->username)->exists();
            if($check) {
                throw new \Exception("Username already exists");
            }

            User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->username),
                'level' => $request->level,
                'username' => $request->username,
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

    public function reset($id) {
        try {
            DB::beginTransaction();

            $user = User::find($id);

            $user->update([
                'password' => Hash::make($user->username),
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

    public function setActive($id) {
        try {
            DB::beginTransaction();

            $user = User::find($id);


            $user->update([
                'active' => $user->active == 1 ? 0 : 1,
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

            $user = User::find($request->id);


            if($user->username != $request->username) {
                $check = User::where('username', $request->username)->exists();
                if($check) {
                    throw new \Exception("Username already exists");
                }
            }

            $user->update([
                'name' => $request->name,
                'email' => $request->email,
                'level' => $request->level,
                'username' => $request->username
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
