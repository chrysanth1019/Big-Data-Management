@extends('layouts.admin')

@section('title', 'ダッシュボード')

@section('content')
<div class="jp-fade-in">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0">ダッシュボード</h1>
        <div class="small text-muted">{{ now()->format('Y年m月d日') }}</div>
    </div>
    
    <div class="jp-pattern-bg mb-4">
        <h2 class="h4 mb-3">ようこそ、{{ auth()->user()->name ?? 'ユーザー' }}さん</h2>
        <p class="mb-0">このシステムでは、ユーザーの管理や活動状況の確認などが可能です。</p>
    </div>
    
    <div class="row mb-4">
        <div class="col-xl-3 col-md-6">
            <div class="jp-stat-card">
                <div class="jp-stat-number">{{ $stats['total_users'] ?? 0 }}</div>
                <div class="jp-stat-title">総ユーザー数</div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="jp-stat-card blue">
                <div class="jp-stat-number">{{ $stats['admin_users'] ?? 0 }}</div>
                <div class="jp-stat-title">管理者数</div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="jp-stat-card gold">
                <div class="jp-stat-number">{{ $stats['blocked_users'] ?? 0 }}</div>
                <div class="jp-stat-title">ブロックユーザー</div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="jp-stat-card green">
                <div class="jp-stat-number">{{ $stats['new_users_today'] ?? 0 }}</div>
                <div class="jp-stat-title">今日の新規ユーザー</div>
            </div>
        </div>
    </div>
    
    <div class="row">
        <div class="col-lg-8">
            <div class="jp-card mb-4">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">ユーザー登録推移（過去7日間）</h5>
                </div>
                <div class="card-body">
                    <div style="height: 300px;">
                        <canvas id="userRegistrationChart" 
                            data-labels="{{ json_encode(array_keys($trend->toArray())) }}"
                            data-values="{{ json_encode(array_values($trend->toArray())) }}">
                        </canvas>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-lg-4">
            <div class="jp-card mb-4">
                <div class="card-header">
                    <h5 class="mb-0">最近のアクティビティ</h5>
                </div>
                <div class="card-body p-0">
                    @if(isset($recentActivities) && $recentActivities->count() > 0)
                        <div class="list-group list-group-flush">
                            @foreach($recentActivities as $activity)
                                <div class="list-group-item jp-activity-item 
                                    @if(str_contains($activity->action, 'login')) login @endif
                                    @if(str_contains($activity->action, 'admin')) admin @endif
                                    @if(str_contains($activity->action, 'block')) block @endif
                                ">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div>
                                            <strong>{{ $activity->name }}</strong> 
                                            <span class="text-muted small">
                                                @switch($activity->action)
                                                    @case('login')
                                                        ログインしました
                                                        @break
                                                    @case('logout')
                                                        ログアウトしました
                                                        @break
                                                    @case('block_user')
                                                        ユーザーをブロックしました
                                                        @break
                                                    @case('unblock_user')
                                                        ユーザーのブロックを解除しました
                                                        @break
                                                    @case('set_admin')
                                                        管理者権限を付与しました
                                                        @break
                                                    @case('remove_admin')
                                                        管理者権限を削除しました
                                                        @break
                                                    @default
                                                        {{ $activity->action }}
                                                @endswitch
                                            </span>
                                        </div>
                                        <div class="jp-activity-time">
                                            {{ $activity->created_at->diffForHumans() }}
                                        </div>
                                    </div>
                                    @if($activity->description)
                                        <div class="small text-muted mt-1">{{ $activity->description }}</div>
                                    @endif
                                </div>
                            @endforeach
                        </div>
                        <div class="text-center p-3">
                            <a href="{{ route('admin.activities') }}" class="btn btn-jp-secondary btn-sm">
                                全てのアクティビティを表示
                            </a>
                        </div>
                    @else
                        <div class="p-4 text-center text-muted">
                            アクティビティがありません
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
    
    <div class="jp-card mb-4">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">最近のユーザー</h5>
            <a href="{{ route('admin.users.index') }}" class="btn btn-jp-secondary btn-sm">
                全てのユーザーを表示
            </a>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0 jp-table">
                    <thead>
                        <tr>
                            <th>名前</th>
                            <th>メールアドレス</th>
                            <th>登録日</th>
                            <th>ステータス</th>
                            <th>アクション</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if(App\Models\User::count() > 0)
                            @foreach(App\Models\User::latest()->limit(5)->get() as $user)
                                <tr>
                                    <td>{{ $user->name }}</td>
                                    <td>{{ $user->email }}</td>
                                    <td>{{ $user->created_at->format('Y/m/d H:i') }}</td>
                                    <td>
                                        @if($user->is_admin)
                                            <span class="badge jp-badge-admin">管理者</span>
                                        @endif
                                        
                                        @if($user->is_blocked)
                                            <span class="badge jp-badge-blocked">ブロック中</span>
                                        @else
                                            <span class="badge jp-badge-active">アクティブ</span>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="d-flex">
                                            <form id="block-form-{{ $user->id }}" action="{{ route('admin.users.toggle-block', $user) }}" method="POST" class="me-2">
                                                @csrf
                                                @method('PATCH')
                                                <button type="button" class="btn btn-sm {{ $user->is_blocked ? 'btn-success' : 'btn-danger' }}" 
                                                        onclick="toggleBlockUser({{ $user->id }}, '{{ $user->name }}', {{ $user->is_blocked ? 'true' : 'false' }})" 
                                                        {{ $user->id === auth()->id() ? 'disabled' : '' }}>
                                                    <i class="bi {{ $user->is_blocked ? 'bi-unlock' : 'bi-lock' }}"></i>
                                                </button>
                                            </form>
                                            
                                            <form id="admin-form-{{ $user->id }}" action="{{ route('admin.users.toggle-admin', $user) }}" method="POST">
                                                @csrf
                                                @method('PATCH')
                                                <button type="button" class="btn btn-sm {{ $user->is_admin ? 'btn-warning' : 'btn-info' }}" 
                                                        onclick="toggleAdminRole({{ $user->id }}, '{{ $user->name }}', {{ $user->is_admin ? 'true' : 'false' }})"
                                                        {{ $user->id === auth()->id() ? 'disabled' : '' }}>
                                                    <i class="bi {{ $user->is_admin ? 'bi-person-dash' : 'bi-person-plus' }}"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        @else
                            <tr>
                                <td colspan="5" class="text-center py-4">
                                    ユーザーがいません
                                </td>
                            </tr>
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection