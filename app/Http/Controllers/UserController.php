<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\UserActivity;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;

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

     public function create()
    {
        return view('admin.users.create');
    }
    
    /**
     * Store a newly created user in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'is_admin' => 'boolean',
        ]);
        
        // Create user with default password
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make('password123'), // Default password
            'is_admin' => $request->has('is_admin') ? true : false,
        ]);
        
        // Log the activity
        UserActivity::log(auth()->id(), 'create_user', "新規ユーザー {$user->name} (ID: {$user->id}) を作成しました");
        
        return redirect()->route('admin.users.index')
            ->with('success', "ユーザーが作成されました。デフォルトパスワード：password123");
    }
    
    /**
     * Show the form for changing user password.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function editPassword(User $user)
    {
        return view('admin.users.change-password', compact('user'));
    }
    
    /**
     * Update the user's password.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function updatePassword(Request $request, User $user)
    {
        $request->validate([
            'password' => 'required|string|min:8|confirmed',
        ]);
        
        $user->password = Hash::make($request->password);
        $user->save();
        
        // Log the activity
        UserActivity::log(auth()->id(), 'change_password', "ユーザー {$user->name} (ID: {$user->id}) のパスワードを変更しました");
        
        return redirect()->route('admin.users.index')
            ->with('success', 'パスワードが変更されました。');
    }
    
    public function destroy(User $user)
    {
        // Prevent deleting yourself
        if ($user->id === auth()->id()) {
            return back()->with('error', '自分自身を削除することはできません。');
        }
        
        $userName = $user->name;
        $userId = $user->id;
        
        // Delete the user
        $user->delete();
        
        // Log the activity
        UserActivity::log(auth()->id(), 'delete_user', "ユーザー {$userName} (ID: {$userId}) を削除しました");
        
        return back()->with('success', 'ユーザーが削除されました。');
    }

    public function editAllowedIps(User $user)
    {
        return view('admin.users.edit-allowed-ips', compact('user'));
    }
    
    /**
     * Update the user's allowed IPs.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function updateAllowedIps(Request $request, User $user)
    {
        $request->validate([
            'allowed_ips' => 'nullable|string',
        ]);
        
        // Process the comma-separated IPs
        $ips = [];
        if ($request->filled('allowed_ips')) {
            $ips = array_map('trim', explode(',', $request->allowed_ips));
            // Filter out empty values
            $ips = array_filter($ips);
            
            // Validate each IP
            foreach ($ips as $ip) {
                if (!filter_var($ip, FILTER_VALIDATE_IP)) {
                    return back()->withErrors([
                        'allowed_ips' => "{$ip} は有効なIPアドレスではありません。",
                    ])->withInput();
                }
            }
        }
        
        // Update the user's allowed IPs
        $user->allowed_ips = $ips;
        $user->save();
        
        // Log the activity
        $ipsDisplay = empty($ips) ? 'すべて' : implode(', ', $ips);
        UserActivity::log(
            auth()->id(), 
            'update_allowed_ips', 
            "ユーザー {$user->name} (ID: {$user->id}) の許可されたIPアドレスを更新しました: {$ipsDisplay}"
        );
        
        return redirect()->route('admin.users.index')
            ->with('success', '許可されたIPアドレスが更新されました。');
    }
}