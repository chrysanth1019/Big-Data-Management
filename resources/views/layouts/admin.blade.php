<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('title', 'Japanese Admin') - 管理パネル</title>
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans+JP:wght@300;400;500;700&family=Shippori+Mincho:wght@400;500;700&display=swap" rel="stylesheet">
    
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    
    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
    
    <!-- Custom CSS -->
    <link rel="stylesheet" href="{{ asset('css/admin.css') }}">
    
    <style>
        :root {
            --jp-red: #D05A6E;
            --jp-dark-red: #B04759;
            --jp-gold: #C89932;
            --jp-dark-gold: #A67B1F;
            --jp-navy: #1A2639;
            --jp-dark-navy: #0F1526;
            --jp-cream: #F8F4E9;
            --jp-teal: #3A7563;
            --jp-dark-teal: #2A5747;
            --jp-light-gray: #E5E3DC;
            --jp-text: #333;
        }
        
        body {
            font-family: 'Noto Sans JP', sans-serif;
            background-color: #F5F5F5;
            color: var(--jp-text);
        }
        
        .jp-logo {
            font-family: 'Shippori Mincho', serif;
            color: var(--jp-cream);
            font-weight: 500;
        }
        
        /* Sidebar Styles */
        .jp-sidebar {
            background-color: var(--jp-navy);
            color: white;
            min-height: 100vh;
            position: fixed;
            top: 0;
            bottom: 0;
            left: 0;
            z-index: 100;
            padding: 0;
            box-shadow: inset -1px 0 0 rgba(0, 0, 0, .1);
        }
        
        .jp-sidebar .position-sticky {
            position: sticky;
            top: 0;
            height: 100vh;
            overflow-y: auto;
        }
        
        .jp-sidebar .nav-link {
            color: rgba(255, 255, 255, 0.7);
            padding: 0.75rem 1.25rem;
            border-left: 3px solid transparent;
            transition: all 0.2s;
        }
        
        .jp-sidebar .nav-link:hover {
            color: white;
            background-color: rgba(255, 255, 255, 0.05);
            border-left-color: var(--jp-red);
        }
        
        .jp-sidebar .nav-link.active {
            color: white;
            background-color: rgba(255, 255, 255, 0.1);
            border-left-color: var(--jp-red);
        }
        
        .sidebar-heading {
            font-size: 0.75rem;
            text-transform: uppercase;
            letter-spacing: 0.1rem;
            color: rgba(255, 255, 255, 0.5);
            padding: 1rem 1.25rem 0.5rem;
        }
        
        /* Navbar Styles */
        .jp-navbar {
            background-color: white;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.05);
            border-bottom: 1px solid rgba(0, 0, 0, 0.05);
        }
        
        /* Content Styles */
        .jp-content {
            margin-left: 0;
            padding: 1.5rem;
        }
        
        @media (min-width: 768px) {
            .jp-content {
                margin-left: 16.666667%;
            }
        }
        
        @media (min-width: 992px) {
            .jp-content {
                margin-left: 16.666667%;
            }
        }
        
        /* Card Styles */
        .jp-card {
            border: none;
            border-radius: 5px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.07);
            overflow: hidden;
        }
        
        .jp-card .card-header {
            background-color: white;
            border-bottom: 1px solid rgba(0, 0, 0, 0.05);
            padding: 1rem 1.25rem;
        }
        
        /* Table Styles */
        .jp-table {
            border-color: rgba(0, 0, 0, 0.05);
        }
        
        .jp-table th {
            background-color: rgba(0, 0, 0, 0.02);
            border-bottom: 2px solid rgba(0, 0, 0, 0.05);
            color: #666;
        }
        
        /* Button Styles */
        .btn-jp-primary {
            background-color: var(--jp-red);
            border: none;
            color: white;
        }
        
        .btn-jp-primary:hover {
            background-color: var(--jp-dark-red);
            color: white;
        }
        
        .btn-jp-secondary {
            background-color: var(--jp-navy);
            border: none;
            color: white;
        }
        
        .btn-jp-secondary:hover {
            background-color: var(--jp-dark-navy);
            color: white;
        }
        
        /* Badge Styles */
        .jp-badge-admin {
            background-color: var(--jp-navy);
            color: white;
        }
        
        .jp-badge-active {
            background-color: var(--jp-teal);
            color: white;
        }
        
        .jp-badge-blocked {
            background-color: var(--jp-red);
            color: white;
        }
        
        /* Stats Cards */
        .jp-stat-card {
            background-color: var(--jp-red);
            color: white;
            border-radius: 5px;
            padding: 1.5rem;
            margin-bottom: 1rem;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            position: relative;
            overflow: hidden;
        }
        
        .jp-stat-card.blue {
            background-color: var(--jp-navy);
        }
        
        .jp-stat-card.gold {
            background-color: var(--jp-gold);
        }
        
        .jp-stat-card.green {
            background-color: var(--jp-teal);
        }
        
        .jp-stat-card::after {
            content: '';
            position: absolute;
            top: 0;
            right: 0;
            width: 30%;
            height: 100%;
            background: rgba(255, 255, 255, 0.1);
            clip-path: polygon(100% 0, 0 0, 100% 100%);
        }
        
        .jp-stat-number {
            font-size: 2.5rem;
            font-weight: 700;
            margin-bottom: 0.5rem;
        }
        
        .jp-stat-title {
            font-size: 0.875rem;
            text-transform: uppercase;
            letter-spacing: 0.05rem;
            opacity: 0.8;
        }
        
        /* Activity List */
        .jp-activity-item {
            border-left: 3px solid transparent;
            transition: all 0.2s;
        }
        
        .jp-activity-item.login {
            border-left-color: var(--jp-teal);
        }
        
        .jp-activity-item.admin {
            border-left-color: var(--jp-navy);
        }
        
        .jp-activity-item.block {
            border-left-color: var(--jp-red);
        }
        
        .jp-activity-time {
            font-size: 0.75rem;
            color: #999;
        }
        
        /* Pattern Background */
        .jp-pattern-bg {
            background-color: white;
            background-image: url("data:image/svg+xml,%3Csvg width='40' height='40' viewBox='0 0 40 40' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='%23f5f5f5' fill-opacity='1' fill-rule='evenodd'%3E%3Cpath d='M0 40L40 0H20L0 20M40 40V20L20 40'/%3E%3C/g%3E%3C/svg%3E");
            border-radius: 5px;
            padding: 1.5rem;
            border-left: 4px solid var(--jp-red);
        }
        
        /* Animation */
        .jp-fade-in {
            animation: fadein 0.5s;
        }
        
        @keyframes fadein {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }
    </style>
</head>
<body>
    <div class="container-fluid">
        <div class="row">
            @include('components.sidebar')
            
            <main class="jp-content col-md-9 ms-sm-auto col-lg-10 px-md-4">
                @include('components.navbar')
                
                <div class="py-3">
                    @yield('content')
                </div>
            </main>
        </div>
    </div>
    
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- Custom JS -->
    <script src="{{ asset('js/admin.js') }}"></script>
    
    <script>
        // Toggle sidebar on mobile
        document.addEventListener('DOMContentLoaded', function() {
            const sidebarToggle = document.getElementById('sidebarToggle');
            const sidebar = document.querySelector('.jp-sidebar');
            
            if (sidebarToggle) {
                sidebarToggle.addEventListener('click', function() {
                    sidebar.classList.toggle('collapse');
                });
            }
            
            // Initialize charts if they exist
            const chartElement = document.getElementById('userRegistrationChart');
            if (chartElement) {
                renderUserChart(chartElement);
            }
        });
        
        // Confirm block/unblock user
        function toggleBlockUser(userId, userName, isBlocked) {
            const action = isBlocked ? 'unblock' : 'block';
            const message = isBlocked 
                ? `本当に ${userName} さんのブロックを解除しますか？` 
                : `本当に ${userName} さんをブロックしますか？`;
                
            if (confirm(message)) {
                document.getElementById(`block-form-${userId}`).submit();
            }
        }
        
        // Confirm admin role toggle
        function toggleAdminRole(userId, userName, isAdmin) {
            const action = isAdmin ? '削除' : '付与';
            if (confirm(`本当に ${userName} さんの管理者権限を${action}しますか？`)) {
                document.getElementById(`admin-form-${userId}`).submit();
            }
        }
    </script>
</body>
</html>