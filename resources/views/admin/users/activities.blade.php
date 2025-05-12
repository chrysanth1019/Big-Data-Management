@extends('layouts.admin')

@section('title', 'アクティビティ履歴')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="h3 mb-0">アクティビティ履歴</h1>
</div>

<div class="jp-card mb-4">
    <div class="card-body">
        <!-- Filters -->
        <form action="{{ route('admin.activities') }}" method="GET" class="row g-3 mb-4">
            <div class="col-md-5">
                <label for="user_id" class="jp-label">ユーザー</label>
                <select name="user_id" id="user_id" class="form-select jp-form-control filter-select">
                    <option value="">すべてのユーザー</option>
                    @foreach($users as $user)
                        <option value="{{ $user->id }}" {{ request('user_id') == $user->id ? 'selected' : '' }}>
                            {{ $user->name }} ({{ $user->email }})
                        </option>
                    @endforeach
                </select>
            </div>
            
            <div class="col-md-4">
                <label for="action" class="jp-label">アクション</label>
                <select name="action" id="action" class="form-select jp-form-control filter-select">
                    <option value="">すべてのアクション</option>
                    <option value="login" {{ request('action') == 'login' ? 'selected' : '' }}>ログイン</option>
                    <option value="logout" {{ request('action') == 'logout' ? 'selected' : '' }}>ログアウト</option>
                    <option value="register" {{ request('action') == 'register' ? 'selected' : '' }}>登録</option>
                    <option value="block_user" {{ request('action') == 'block_user' ? 'selected' : '' }}>ユーザーをブロック</option>
                    <option value="unblock_user" {{ request('action') == 'unblock_user' ? 'selected' : '' }}>ユーザーのブロックを解除</option>
                    <option value="set_admin" {{ request('action') == 'set_admin' ? 'selected' : '' }}>管理者権限の付与</option>
                    <option value="remove_admin" {{ request('action') == 'remove_admin' ? 'selected' : '' }}>管理者権限の削除</option>
                </select>
            </div>
            
            <div class="col-md-3 d-flex align-items-end">
                <button type="submit" class="btn btn-jp-primary w-100">フィルター適用</button>
            </div>
        </form>
        
        <!-- Activities Table -->
        <div class="table-responsive">
            <table class="table table-hover jp-table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>ユーザー</th>
                        <th>アクション</th>
                        <th>説明</th>
                        <th>IPアドレス</th>
                        <th>日時</th>
                    </tr>
                </thead>
                <tbody>
                    @if(count($activities) > 0)
                        @foreach($activities as $activity)
                            <tr>
                                <td>{{ $activity->id }}</td>
                                <td>{{ $activity->name ?? '不明' }}</td>
                                <td>
                                    <span class="badge 
                                        @if(str_contains($activity->action, 'login')) bg-info
                                        @elseif(str_contains($activity->action, 'block')) bg-danger
                                        @elseif(str_contains($activity->action, 'admin')) jp-badge-admin
                                        @else bg-secondary
                                        @endif">
                                        {{ $activity->action }}
                                    </span>
                                </td>
                                <td>{{ $activity->description }}</td>
                                <td><small>{{ $activity->ip_address }}</small></td>
                                <td>{{ $activity->created_at->format('Y/m/d H:i:s') }}</td>
                            </tr>
                        @endforeach
                    @else
                        <tr>
                            <td colspan="6" class="text-center py-4">
                                <i class="bi bi-calendar-x mb-2" style="font-size: 2rem;"></i>
                                <p class="mb-0">アクティビティが見つかりませんでした</p>
                            </td>
                        </tr>
                    @endif
                </tbody>
            </table>
        </div>
        
        <!-- Pagination -->
        <div class="d-flex justify-content-center mt-4">
            {{ $activities->withQueryString()->links() }}
        </div>
    </div>
</div>
@endsection