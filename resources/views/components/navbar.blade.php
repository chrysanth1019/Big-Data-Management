<nav class="jp-navbar navbar navbar-expand-md navbar-light sticky-top py-2">
    <div class="container-fluid">
        <button id="sidebarToggle" class="btn d-md-none me-2">
            <i class="bi bi-list"></i>
        </button>
        
        <a class="navbar-brand d-md-none jp-logo" href="{{ route('admin.dashboard') }}">管理パネル</a>
        
        <ul class="navbar-nav ms-auto mb-2 mb-md-0">
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                    <i class="bi bi-person-circle me-1"></i>
                    {{ auth()->user()->name ?? 'ユーザー' }}
                </a>
                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="dropdown-item">
                            <i class="bi bi-box-arrow-right me-2"></i>
                            ログアウト
                        </button>
                    </form>
                </ul>
            </li>
        </ul>
    </div>
</nav>