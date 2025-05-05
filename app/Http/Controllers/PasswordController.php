<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rules\Password;

class PasswordController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    /**
     * Show the form for changing password
     */
    public function showChangePasswordForm()
    {
        return view('change-password');
    }
    
    /**
     * Change the user's password
     */
    public function changePassword(Request $request)
    {
        $request->validate([
            'current_password' => ['required', function ($attribute, $value, $fail) {
                if (!Hash::check($value, Auth::user()->password)) {
                    $fail('現在のパスワードが正しくありません。');
                }
            }],
            'password' => ['required', 'confirmed', Password::min(8)
                ->letters()
                ->mixedCase()
                ->numbers()
                ->symbols()
            ],
        ], [
            'current_password.required' => '現在のパスワードを入力してください。',
            'password.required' => '新しいパスワードを入力してください。',
            'password.confirmed' => '新しいパスワードの確認が一致しません。',
        ]);
        
        $userId = Auth::id();
        $user = \App\Models\User::where('id', $userId)->first();
        $user->password = Hash::make($request->password);
        $user->save();
        
        return redirect()
            ->route('password.change')
            ->with('success', 'パスワードが正常に変更されました。');
    }
}