<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Http\Helpers\PublicFunctions;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class ApiLoginController extends Controller
{
    public function login(Request $request)
    {
        $request->validate([
            'username' => 'required',
            'password' => 'required',
        ]);

        $user = User::where('username', $request->username)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json(['message' => 'Invalid credentials'], 401);
        }

        $token = $user->createToken('api-token')->plainTextToken;

        $data = PublicFunctions::userStatus($user->id);

        return response()->json([
            'token' => $token,
            'user' => $data,
        ]);
    }

    public function logout(Request $request)
    {

        $request->user()->currentAccessToken()->delete();

        return response()->json(['message' => 'Logged out']);
    }

    public function profile(Request $request)
    {
        $user_id = $request->user()->id;

        $data = DB::select("
            select
                u.*,
                case when a.id is not null then '1' else '0' end as is_absen
            from users u
            left join attendances a on a.user_id = u.id and a.check_out_time is null
            where id = $user_id
        ");
        return response()->json([
            'message' => 'success',
            'data' => $data,
        ]);
    }

    public function change_password(Request $request) {
        try {

            $user = $request->user();

            if(password_verify($request->old_password, $user->password)) {
                User::find($user->id)->update([
                    'password' => Hash::make($request->new_password)
                ]);

                return response()->json([
                    'message' => 'success',
                ]);

            } else {
                return response()->json([
                    'message' => 'Old password is incorrect'
                ], 400);
            }

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(["message" => $e->getMessage(), "trace" => $e->getTrace()], 500);
        }
    }
}
