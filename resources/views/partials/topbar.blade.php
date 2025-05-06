<nav class="navbar navbar-expand-lg jp-navbar">
    <div class="container">
        <a class="navbar-brand" href="/">
            <img src="{{ asset('images/logo.svg') }}" alt="データサービス" class="logo-img">
        </a>
        
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <i class="bi bi-list"></i>
        </button>
        
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">
                <!-- <li class="nav-item">
                    <a class="nav-link jp-nav-link {{ request()->is('/') ? 'active' : '' }}" href="/">
                        <i class="bi bi-house-door-fill me-1"></i> ホーム
                    </a>
                </li> -->
                @auth
                <li class="nav-item">
                    <a class="nav-link jp-nav-link {{ request()->is('search*') ? 'active' : '' }}" href="{{ route('simple-search.index') }}">
                        <i class="bi bi-search me-1"></i> 検索
                    </a>
                </li>
                @endauth
                <li class="nav-item">
                    <a class="nav-link jp-nav-link " href="{{ route('myip') }}">
                        <i class="bi bi-globe"></i> 私のIP
                    </a>
                </li>
                
                @auth
                    @if(auth()->user()->is_admin)
                        <li class="nav-item">
                            <a class="nav-link jp-nav-link {{ request()->is('admin*') ? 'active' : '' }}" href="{{ route('admin.dashboard') }}">
                                <i class="bi bi-speedometer2 me-1"></i> 管理パネル
                            </a>
                        </li>
                    @endif
                     <li class="nav-item dropdown">
                        <a class="nav-link jp-nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="bi bi-person-circle me-1"></i> {{ auth()->user()->name }}
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end dropdown-menu-dark" aria-labelledby="userDropdown">
                            <li>
                                <a class="dropdown-item" href="{{ route('password.change') }}">
                                    <i class="bi bi-key-fill me-2"></i>パスワード変更
                                </a>
                            </li>
                            <li><hr class="dropdown-divider"></li>
                            <li>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="dropdown-item">
                                        <i class="bi bi-box-arrow-right me-2"></i>ログアウト
                                    </button>
                                </form>
                            </li>
                        </ul>
                    </li>
                    
                @else
                    <li class="nav-item">
                        <a class="nav-link jp-nav-link" href="{{ route('login') }}">
                            <i class="bi bi-box-arrow-in-right me-1"></i> ログイン
                        </a>
                    </li>
                @endauth
            </ul>
        </div>
    </div>
</nav>

<style>
    /* Navbar styles */
    .jp-navbar {
        background-color: white;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
        padding: 0.5rem 1rem;
        width: 100%;
        z-index: 1000;
        transition: all 0.3s ease;
    }
    
    .jp-navbar.scrolled {
        padding: 0.3rem 1rem;
        box-shadow: 0 3px 15px rgba(0, 0, 0, 0.1);
    }
    
    .navbar-brand {
        display: flex;
        align-items: center;
    }
    
    .logo-text {
        font-family: 'Shippori Mincho', serif;
        font-size: 1.4rem;
        margin-left: 0.5rem;
        color: var(--jp-navy);
        font-weight: 600;
    }
    
    .logo-img {
        height: 40px;
    }
    
    .jp-nav-link {
        color: var(--jp-navy);
        font-weight: 500;
        padding: 0.5rem 1rem;
        margin: 0 0.2rem;
        position: relative;
        transition: all 0.3s;
    }
    
    .jp-nav-link::after {
        content: '';
        position: absolute;
        width: 0;
        height: 2px;
        bottom: 0;
        left: 50%;
        transform: translateX(-50%);
        background-color: var(--jp-blue);
        transition: all 0.3s;
    }
    
    .jp-nav-link:hover {
        color: var(--jp-blue);
    }
    
    .jp-nav-link:hover::after {
        width: 60%;
    }
    
    .jp-nav-link.active {
        color: var(--jp-blue);
        font-weight: 600;
    }
    
    .jp-nav-link.active::after {
        width: 60%;
    }
</style>

<script>
    // Navbar scroll effect
    window.addEventListener('scroll', function() {
        const navbar = document.querySelector('.jp-navbar');
        if (window.scrollY > 50) {
            navbar.classList.add('scrolled');
        } else {
            navbar.classList.remove('scrolled');
        }
    });
</script>