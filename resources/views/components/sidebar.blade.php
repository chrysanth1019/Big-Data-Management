<div class="jp-sidebar col-md-3 col-lg-2 d-md-block collapse">
    <div class="position-sticky">
        <div class="text-center py-4">
            <h3 class="jp-logo">管理パネル</h3>
            <div class="small text-light">Admin Panel</div>
        </div>
        
        <hr class="mx-3 bg-light opacity-25">
        
        <ul class="nav flex-column">
            <li class="nav-item">
                <a href="{{ route('admin.dashboard') }}" class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                    <i class="bi bi-speedometer2 me-2"></i>
                    ダッシュボード
                </a>
            </li>
            
            <div class="sidebar-heading">
                ユーザー管理
            </div>
            
            <li class="nav-item">
                <a href="{{ route('admin.users.index') }}" class="nav-link {{ request()->routeIs('admin.users.index') ? 'active' : '' }}">
                    <i class="bi bi-people me-2"></i>
                    ユーザー一覧
                </a>
            </li>
            
            <!-- <li class="nav-item">
                <a href="{{ route('admin.activities') }}" class="nav-link {{ request()->routeIs('admin.activities') ? 'active' : '' }}">
                    <i class="bi bi-activity me-2"></i>
                    アクティビティ履歴
                </a>
            </li> -->
            
            <div class="sidebar-heading">
                設定
            </div>
            
            <li class="nav-item">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="nav-link border-0 bg-transparent">
                        <i class="bi bi-box-arrow-right me-2"></i>
                        ログアウト
                    </button>
                </form>
            </li>
        </ul>
        
        <hr class="mx-3 bg-light opacity-25">
        
        <div class="px-3 small text-light mb-3">
            <div class="d-flex align-items-center mb-2">
                <div class="me-2 position-relative">
                    <i class="bi bi-person-circle fs-5"></i>
                </div>
                <div>
                    <div class="fw-bold">{{ auth()->user()->name ?? 'ユーザー' }}</div>
                    <div class="text-muted small">管理者</div>
                </div>
            </div>
        </div>
    </div>
</div>