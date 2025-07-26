<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
    public function index()
    {
        if(auth()->check()) {
            if(password_verify(auth()->user()->username, auth()->user()->password)) {
                return view('Login.changePassword');
            } else {
                return redirect('/');
            }
        }
        return view('Login.index');
    }

    public function login (Request $request)
    {


        if(auth()->attempt($request->only('username', 'password'))) {
            $url = '';
            if(password_verify(auth()->user()->username, auth()->user()->password)) {
                $url = '/login';
            } else {
                $url = '/';
            }

            return response()->json([
                'success' => true,
                'data' => [
                    'url' => $url,
                ]
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Username or password is incorrect'
            ], 400);
        }

    }

    public function logout() {
        auth()->logout();
        return redirect('/login');
    }

    public function changePassword(Request $request) {

        if(password_verify($request->oldPassword, auth()->user()->password)) {
            User::find(auth()->id())->update([
               'password' => Hash::make($request->newPassword)
            ]);

            return response()->json([
                'success' => true,
                'data' => [
                    'url' => '/login',
                ]
            ]);

        } else {
            return response()->json([
                'success' => false,
                'message' => 'Old password is incorrect'
            ], 400);
        }
    }

}
