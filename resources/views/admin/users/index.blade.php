@extends('layouts.admin')

@section('title', 'ユーザー管理')

@section('content')
<div class="jp-fade-in">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0">ユーザー管理</h1>
        
        <div class="d-flex">
            <a href="{{ route('admin.users.create') }}" class="btn btn-jp-primary me-3">
                <i class="bi bi-person-plus me-1"></i> 新規ユーザー追加
            </a>
            <div class="jp-search">
                <form action="{{ route('admin.users.index') }}" method="GET" class="d-flex">
                    <div class="position-relative me-2">
                        <i class="bi bi-search search-icon"></i>
                        <input type="text" name="search" class="form-control" placeholder="ユーザー検索..." value="{{ request('search') }}">
                    </div>
                    <button type="submit" class="btn btn-jp-secondary">検索</button>
                </form>
            </div>
        </div>
    </div>
    
    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show mb-4" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
    
    <div class="jp-card mb-4">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">ユーザー一覧</h5>
            <div class="btn-group">
                <a href="{{ route('admin.users.index', ['filter' => 'all']) }}" class="btn btn-sm {{ !request('filter') || request('filter') == 'all' ? 'btn-jp-secondary' : 'btn-outline-secondary' }}">
                    すべて
                </a>
                <a href="{{ route('admin.users.index', ['filter' => 'admin']) }}" class="btn btn-sm {{ request('filter') == 'admin' ? 'btn-jp-secondary' : 'btn-outline-secondary' }}">
                    管理者
                </a>
                <a href="{{ route('admin.users.index', ['filter' => 'blocked']) }}" class="btn btn-sm {{ request('filter') == 'blocked' ? 'btn-jp-secondary' : 'btn-outline-secondary' }}">
                    ブロック中
                </a>
            </div>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0 jp-table">
                    <thead>
                        <tr>
                            <th style="width: 60px;">ID</th>
                            <th>名前</th>
                            <th>メールアドレス</th>
                            <th>登録日</th>
                            <th>最終ログイン</th>
                            <th>ステータス</th>
                            <th>アクション</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if($users->count() > 0)
                            @foreach($users as $user)
                                <tr>
                                    <td>{{ $user->id }}</td>
                                    <td>{{ $user->name }}</td>
                                    <td>{{ $user->email }}</td>
                                    <td>{{ $user->created_at->format('Y/m/d H:i') }}</td>
                                    <td>
                                        @if($user->last_login_at)
                                            {{ \Carbon\Carbon::parse($user->last_login_at)->format('Y/m/d H:i') }}
                                        @else
                                            <span class="text-muted">未ログイン</span>
                                        @endif
                                    </td>
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
                                            <a href="{{ route('admin.users.edit-password', $user) }}" class="btn btn-sm btn-primary me-2" title="パスワード変更">
                                                <i class="bi bi-key"></i>
                                            </a>
                                            
                                            <form id="block-form-{{ $user->id }}" action="{{ route('admin.users.toggle-block', $user) }}" method="POST" class="me-2">
                                                @csrf
                                                @method('PATCH')
                                                <button type="button" class="btn btn-sm {{ $user->is_blocked ? 'btn-success' : 'btn-danger' }}" 
                                                        onclick="toggleBlockUser({{ $user->id }}, '{{ $user->name }}', {{ $user->is_blocked ? 'true' : 'false' }})" 
                                                        {{ $user->id === auth()->id() ? 'disabled' : '' }}>
                                                    <i class="bi {{ $user->is_blocked ? 'bi-unlock' : 'bi-lock' }}"></i>
                                                </button>
                                            </form>
                                            
                                            <form id="admin-form-{{ $user->id }}" action="{{ route('admin.users.toggle-admin', $user) }}" method="POST" class="me-2">
                                                @csrf
                                                @method('PATCH')
                                                <button type="button" class="btn btn-sm {{ $user->is_admin ? 'btn-warning' : 'btn-info' }}" 
                                                        onclick="toggleAdminRole({{ $user->id }}, '{{ $user->name }}', {{ $user->is_admin ? 'true' : 'false' }})"
                                                        {{ $user->id === auth()->id() ? 'disabled' : '' }}>
                                                    <i class="bi {{ $user->is_admin ? 'bi-person-dash' : 'bi-person-plus' }}"></i>
                                                </button>
                                            </form>
                                            
                                            <form id="delete-form-{{ $user->id }}" action="{{ route('admin.users.destroy', $user) }}" method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <button type="button" class="btn btn-sm btn-danger" 
                                                        onclick="deleteUser({{ $user->id }}, '{{ $user->name }}')"
                                                        {{ $user->id === auth()->id() ? 'disabled' : '' }} title="ユーザー削除">
                                                    <i class="bi bi-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        @else
                            <tr>
                                <td colspan="7" class="text-center py-4">
                                    一致するユーザーが見つかりませんでした
                                </td>
                            </tr>
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
        @if($users->hasPages())
            <div class="card-footer">
                <div class="jp-pagination">
                    {{ $users->withQueryString()->links() }}
                </div>
            </div>
        @endif
    </div>
</div>
@endsection