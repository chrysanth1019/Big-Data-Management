<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\UserActivity;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
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
     * Show the admin dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function dashboard()
    {
        // User statistics
        $stats = [
            'total_users' => User::count(),
            'admin_users' => User::where('is_admin', true)->count(),
            'blocked_users' => User::where('is_blocked', true)->count(),
            'new_users_today' => User::whereDate('created_at', Carbon::today())->count(),
        ];

        // User registration trend for the past 7 days
        $trend = collect();
        for ($i = 6; $i >= 0; $i--) {
            $date = Carbon::now()->subDays($i);
            $count = User::whereDate('created_at', $date)->count();
            $trend->put($date->format('m/d'), $count);
        }

        // Recent activities
        $recentActivities = UserActivity::with('user')
            ->latest()
            ->limit(5)
            ->get();

        return view('admin.dashboard', compact('stats', 'trend', 'recentActivities'));
    }

    /**
     * Show the activity logs.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function activities(Request $request)
    {
        $query = UserActivity::with('user')->latest();

        // Filter by user
        if ($request->has('user_id') && $request->user_id) {
            $query->where('user_id', $request->user_id);
        }

        // Filter by action
        if ($request->has('action') && $request->action) {
            $query->where('action', $request->action);
        }

        // Date range filter
        if ($request->has('date_from') && $request->date_from) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }

        if ($request->has('date_to') && $request->date_to) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }

        $activities = $query->paginate(15)->withQueryString();
        
        // Get all users for filter dropdown
        $users = User::orderBy('name')->get();
        
        // Get all unique activity types
        $actionTypes = UserActivity::select('action')->distinct()->pluck('action');

        return view('admin.activities', compact('activities', 'users', 'actionTypes'));
    }
}