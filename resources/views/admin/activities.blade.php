@extends('layouts.admin')

@section('title', 'アクティビティ履歴')

@section('content')
<div class="jp-fade-in">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0">アクティビティ履歴</h1>
    </div>
    
    <div class="jp-card mb-4">
        <div class="card-header">
            <h5 class="mb-0">フィルター</h5>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.activities') }}" method="GET">
                <div class="row g-3">
                    <div class="col-md-3">
                        <label for="user_id" class="form-label jp-label">ユーザー</label>
                        <select name="user_id" id="user_id" class="form-select">
                            <option value="">すべてのユーザー</option>
                            @foreach($users as $user)
                                <option value="{{ $user->id }}" {{ request('user_id') == $user->id ? 'selected' : '' }}>
                                    {{ $user->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    
                    <div class="col-md-3">
                        <label for="action" class="form-label jp-label">アクション</label>
                        <select name="action" id="action" class="form-select">
                            <option value="">すべてのアクション</option>
                            @foreach($actionTypes as $action)
                                <option value="{{ $action }}" {{ request('action') == $action ? 'selected' : '' }}>
                                    @switch($action)
                                        @case('login')
                                            ログイン
                                            @break
                                        @case('logout')
                                            ログアウト
                                            @break
                                        @case('register')
                                            ユーザー登録
                                            @break
                                        @case('block_user')
                                            ユーザーブロック
                                            @break
                                        @case('unblock_user')
                                            ブロック解除
                                            @break
                                        @case('set_admin')
                                            管理者権限付与
                                            @break
                                        @case('remove_admin')
                                            管理者権限削除
                                            @break
                                        @default
                                            {{ $action }}
                                    @endswitch
                                </option>
                            @endforeach
                        </select>
                    </div>
                    
                    <div class="col-md-3">
                        <label for="date_from" class="form-label jp-label">開始日</label>
                        <input type="date" class="form-control" id="date_from" name="date_from" value="{{ request('date_from') }}">
                    </div>
                    
                    <div class="col-md-3">
                        <label for="date_to" class="form-label jp-label">終了日</label>
                        <input type="date" class="form-control" id="date_to" name="date_to" value="{{ request('date_to') }}">
                    </div>
                </div>
                
                <div class="mt-3">
                    <button type="submit" class="btn btn-jp-primary">
                        <i class="bi bi-search me-1"></i> 検索
                    </button>
                    <a href="{{ route('admin.activities') }}" class="btn btn-secondary">
                        <i class="bi bi-x-circle me-1"></i> リセット
                    </a>
                </div>
            </form>
        </div>
    </div>
    
    <div class="jp-card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">アクティビティ一覧</h5>
            <span class="badge bg-secondary">{{ $activities->total() }} 件</span>
        </div>
        
        <div class="table-responsive">
            <table class="table table-hover mb-0 jp-table">
                <thead>
                    <tr>
                        <th>ユーザー</th>
                        <th>アクション</th>
                        <th>詳細</th>
                        <th>IPアドレス</th>
                        <th>日時</th>
                    </tr>
                </thead>
                <tbody>
                    @if($activities->count() > 0)
                        @foreach($activities as $activity)
                            <tr>
                                <td>
                                    <strong>{{ $activity->user->name }}</strong>
                                    @if($activity->user->is_admin)
                                        <span class="badge jp-badge-admin ms-1">管理者</span>
                                    @endif
                                </td>
                                <td>
                                    <span class="badge
                                        @if(str_contains($activity->action, 'login')) bg-primary
                                        @elseif(str_contains($activity->action, 'admin')) jp-badge-admin
                                        @elseif(str_contains($activity->action, 'block')) jp-badge-blocked
                                        @elseif($activity->action === 'register') bg-info text-dark
                                        @else bg-secondary
                                        @endif
                                    ">
                                        @switch($activity->action)
                                            @case('login')
                                                <i class="bi bi-box-arrow-in-right me-1"></i> ログイン
                                                @break
                                            @case('logout')
                                                <i class="bi bi-box-arrow-right me-1"></i> ログアウト
                                                @break
                                            @case('register')
                                                <i class="bi bi-person-plus me-1"></i> ユーザー登録
                                                @break
                                            @case('block_user')
                                                <i class="bi bi-lock me-1"></i> ブロック
                                                @break
                                            @case('unblock_user')
                                                <i class="bi bi-unlock me-1"></i> ブロック解除
                                                @break
                                            @case('set_admin')
                                                <i class="bi bi-shield-plus me-1"></i> 管理者権限付与
                                                @break
                                            @case('remove_admin')
                                                <i class="bi bi-shield-minus me-1"></i> 管理者権限削除
                                                @break
                                            @default
                                                {{ $activity->action }}
                                        @endswitch
                                    </span>
                                </td>
                                <td>{{ $activity->description }}</td>
                                <td><span class="text-muted">{{ $activity->ip_address }}</span></td>
                                <td>{{ $activity->created_at->format('Y/m/d H:i:s') }}</td>
                            </tr>
                        @endforeach
                    @else
                        <tr>
                            <td colspan="5" class="text-center py-4">
                                アクティビティが見つかりませんでした
                            </td>
                        </tr>
                    @endif
                </tbody>
            </table>
        </div>
        
        @if($activities->hasPages())
            <div class="card-footer">
                <div class="jp-pagination">
                    {{ $activities->withQueryString()->links() }}
                </div>
            </div>
        @endif
    </div>
</div>
@endsection