<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\UserActivity;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        // $this->middleware('auth');
        // $this->middleware('admin');
    }

    /**
     * Display a listing of users.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $query = User::latest();
        
        // Filter by search term
        if ($request->has('search') && $request->search) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }
        
        // Filter by user type
        if ($request->has('filter')) {
            switch ($request->filter) {
                case 'admin':
                    $query->where('is_admin', true);
                    break;
                case 'blocked':
                    $query->where('is_blocked', true);
                    break;
            }
        }
        
        $users = $query->paginate(15)->withQueryString();
        
        return view('admin.users.index', compact('users'));
    }

    /**
     * Toggle the user's block status.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function toggleBlock(User $user)
    {
        // Prevent blocking yourself
        if ($user->id === auth()->id()) {
            return back()->with('error', '自分自身をブロックすることはできません。');
        }
        
        $user->is_blocked = !$user->is_blocked;
        $user->save();
        
        // Log the activity
        $action = $user->is_blocked ? 'block_user' : 'unblock_user';
        $description = $user->is_blocked 
            ? "ユーザー {$user->name} (ID: {$user->id}) をブロックしました" 
            : "ユーザー {$user->name} (ID: {$user->id}) のブロックを解除しました";
        
        UserActivity::log(auth()->id(), $action, $description);
        
        $message = $user->is_blocked 
            ? 'ユーザーがブロックされました。' 
            : 'ユーザーのブロックが解除されました。';
        
        return back()->with('success', $message);
    }

    /**
     * Toggle the user's admin status.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function toggleAdmin(User $user)
    {
        // Prevent removing admin from yourself
        if ($user->id === auth()->id()) {
            return back()->with('error', '自分自身の管理者権限を削除することはできません。');
        }
        
        $user->is_admin = !$user->is_admin;
        $user->save();
        
        // Log the activity
        $action = $user->is_admin ? 'set_admin' : 'remove_admin';
        $description = $user->is_admin 
            ? "ユーザー {$user->name} (ID: {$user->id}) に管理者権限を付与しました" 
            : "ユーザー {$user->name} (ID: {$user->id}) の管理者権限を削除しました";
        
        UserActivity::log(auth()->id(), $action, $description);
        
        $message = $user->is_admin 
            ? 'ユーザーに管理者権限が付与されました。' 
            : 'ユーザーの管理者権限が削除されました。';
        
        return back()->with('success', $message);
    }
}