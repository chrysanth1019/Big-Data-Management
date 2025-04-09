<?php
// Sample user data (in a real application, this would come from a database)
$user = [
    'id' => 1,
    'name' => 'テスト ユーザー',
    'email' => 'test@example.com',
    'role' => '管理者',
    'registration_date' => '2023-01-15',
    'last_login' => '2023-04-09',
    'profile_image' => 'https://via.placeholder.com/150',
    'bio' => '日本スタイルのウェブアプリケーションを使用しているテストユーザーです。データの検索と管理に興味があります。',
    'preferences' => [
        'default_category' => '文化',
        'save_search_history' => true,
        'notifications' => true,
        'display_mode' => 'light'
    ]
];

// Get notifications
$notifications = [
    [
        'id' => 1,
        'type' => 'system',
        'message' => 'システムメンテナンスが予定されています',
        'date' => '2023-04-15',
        'read' => false
    ],
    [
        'id' => 2,
        'type' => 'search',
        'message' => '新しい検索結果が見つかりました',
        'date' => '2023-04-08',
        'read' => true
    ],
    [
        'id' => 3,
        'type' => 'system',
        'message' => 'プロフィールを更新してください',
        'date' => '2023-04-01',
        'read' => true
    ]
];

// Get search history
$searchHistory = [
    [
        'id' => 1,
        'query' => '京都',
        'filters' => 'カテゴリー: 旅行, 文化',
        'date' => '2023-04-09',
        'results' => 12
    ],
    [
        'id' => 2,
        'query' => '経済政策',
        'filters' => 'カテゴリー: 経済, 政治',
        'date' => '2023-04-08',
        'results' => 8
    ],
    [
        'id' => 3,
        'query' => '日本料理',
        'filters' => 'カテゴリー: 料理',
        'date' => '2023-04-05',
        'results' => 15
    ]
];

// Active tab
$activeTab = isset($_GET['tab']) ? $_GET['tab'] : 'profile';
?>
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>プロフィール - 日本スタイルのウェブアプリケーション</title>
    
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Google Fonts - Japanese fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans+JP:wght@300;400;500;700&family=Noto+Serif+JP:wght@400;700&display=swap" rel="stylesheet">
    
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    
    <!-- Custom Japanese-style CSS -->
    <link href="css/japanese-style.css" rel="stylesheet">
    
    <!-- Zen-like Mobile CSS -->
    <link href="css/zen-mobile.css" rel="stylesheet">
</head>
<body>
    <header class="jp-header">
        <nav class="navbar navbar-expand-lg navbar-light">
            <div class="container">
                <a class="navbar-brand" href="/">
                    <span class="jp-logo">和</span>
                    <span class="jp-title">検索アプリ</span>
                </a>
                
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" 
                        data-bs-target="#navbarNav" aria-controls="navbarNav" 
                        aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav ms-auto">
                        <li class="nav-item">
                            <a class="nav-link" href="/dashboard.php">ダッシュボード</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="/search.php">検索</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link active" href="/profile.php">プロフィール</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="/login.php">ログアウト</a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
    </header>

    <main class="jp-main">
        <div class="container py-4">
            <div class="jp-profile-container">
                <div class="row">
                    <div class="col-lg-4 mb-4">
                        <div class="jp-card jp-profile-sidebar">
                            <div class="jp-card-header text-center">
                                <div class="jp-profile-image">
                                    <img src="<?php echo htmlspecialchars($user['profile_image']); ?>" alt="プロフィール画像" class="rounded-circle">
                                </div>
                                <h2 class="jp-profile-name"><?php echo htmlspecialchars($user['name']); ?></h2>
                                <p class="jp-profile-role"><?php echo htmlspecialchars($user['role']); ?></p>
                                <div class="jp-divider">
                                    <div class="jp-divider-inner"></div>
                                </div>
                            </div>
                            
                            <div class="jp-card-body">
                                <ul class="jp-profile-tabs">
                                    <li class="jp-profile-tab-item <?php echo $activeTab === 'profile' ? 'active' : ''; ?>">
                                        <a href="?tab=profile" class="jp-profile-tab-link">
                                            <i class="fas fa-user me-2"></i>プロフィール
                                        </a>
                                    </li>
                                    <li class="jp-profile-tab-item <?php echo $activeTab === 'preferences' ? 'active' : ''; ?>">
                                        <a href="?tab=preferences" class="jp-profile-tab-link">
                                            <i class="fas fa-cog me-2"></i>設定
                                        </a>
                                    </li>
                                    <li class="jp-profile-tab-item <?php echo $activeTab === 'notifications' ? 'active' : ''; ?>">
                                        <a href="?tab=notifications" class="jp-profile-tab-link">
                                            <i class="fas fa-bell me-2"></i>通知
                                            <?php if(count(array_filter($notifications, function($n) { return !$n['read']; }))): ?>
                                                <span class="jp-notification-badge"><?php echo count(array_filter($notifications, function($n) { return !$n['read']; })); ?></span>
                                            <?php endif; ?>
                                        </a>
                                    </li>
                                    <li class="jp-profile-tab-item <?php echo $activeTab === 'history' ? 'active' : ''; ?>">
                                        <a href="?tab=history" class="jp-profile-tab-link">
                                            <i class="fas fa-history me-2"></i>検索履歴
                                        </a>
                                    </li>
                                    <li class="jp-profile-tab-item <?php echo $activeTab === 'security' ? 'active' : ''; ?>">
                                        <a href="?tab=security" class="jp-profile-tab-link">
                                            <i class="fas fa-shield-alt me-2"></i>セキュリティ
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-lg-8">
                        <div class="jp-card">
                            <!-- Profile Tab -->
                            <?php if($activeTab === 'profile'): ?>
                                <div class="jp-card-header">
                                    <h1 class="jp-title">プロフィール情報</h1>
                                    <div class="jp-divider">
                                        <div class="jp-divider-inner"></div>
                                    </div>
                                </div>
                                
                                <div class="jp-card-body">
                                    <form id="profileForm">
                                        <div class="row mb-4">
                                            <div class="col-md-6">
                                                <label for="name" class="form-label jp-label">名前</label>
                                                <div class="jp-input-wrapper">
                                                    <input id="name" type="text" class="form-control jp-input" 
                                                        name="name" value="<?php echo htmlspecialchars($user['name']); ?>">
                                                </div>
                                            </div>
                                            
                                            <div class="col-md-6">
                                                <label for="email" class="form-label jp-label">メールアドレス</label>
                                                <div class="jp-input-wrapper">
                                                    <input id="email" type="email" class="form-control jp-input" 
                                                        name="email" value="<?php echo htmlspecialchars($user['email']); ?>">
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <div class="mb-4">
                                            <label for="bio" class="form-label jp-label">自己紹介</label>
                                            <div class="jp-input-wrapper">
                                                <textarea id="bio" class="form-control jp-input" 
                                                    name="bio" rows="4"><?php echo htmlspecialchars($user['bio']); ?></textarea>
                                            </div>
                                        </div>
                                        
                                        <div class="mb-4">
                                            <label for="profile_image" class="form-label jp-label">プロフィール画像</label>
                                            <div class="jp-input-wrapper">
                                                <input id="profile_image" type="file" class="form-control jp-input" 
                                                    name="profile_image">
                                            </div>
                                            <small class="form-text jp-small-text">最大2MBの.jpg、.png、または.gifファイル</small>
                                        </div>
                                        
                                        <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                                            <button type="submit" class="btn jp-btn jp-btn-primary">
                                                変更を保存
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            <?php endif; ?>
                            
                            <!-- Preferences Tab -->
                            <?php if($activeTab === 'preferences'): ?>
                                <div class="jp-card-header">
                                    <h1 class="jp-title">ユーザー設定</h1>
                                    <div class="jp-divider">
                                        <div class="jp-divider-inner"></div>
                                    </div>
                                </div>
                                
                                <div class="jp-card-body">
                                    <form id="preferencesForm">
                                        <h3 class="jp-preferences-section-title">表示設定</h3>
                                        
                                        <div class="mb-4">
                                            <label for="display_mode" class="form-label jp-label">表示モード</label>
                                            <div class="jp-select-wrapper">
                                                <select id="display_mode" class="form-select jp-select" name="display_mode">
                                                    <option value="light" <?php echo $user['preferences']['display_mode'] === 'light' ? 'selected' : ''; ?>>ライトモード</option>
                                                    <option value="dark" <?php echo $user['preferences']['display_mode'] === 'dark' ? 'selected' : ''; ?>>ダークモード</option>
                                                    <option value="auto" <?php echo $user['preferences']['display_mode'] === 'auto' ? 'selected' : ''; ?>>システム設定に合わせる</option>
                                                </select>
                                            </div>
                                        </div>
                                        
                                        <h3 class="jp-preferences-section-title">検索設定</h3>
                                        
                                        <div class="mb-4">
                                            <label for="default_category" class="form-label jp-label">デフォルトカテゴリー</label>
                                            <div class="jp-select-wrapper">
                                                <select id="default_category" class="form-select jp-select" name="default_category">
                                                    <option value="">指定なし</option>
                                                    <option value="旅行" <?php echo $user['preferences']['default_category'] === '旅行' ? 'selected' : ''; ?>>旅行</option>
                                                    <option value="料理" <?php echo $user['preferences']['default_category'] === '料理' ? 'selected' : ''; ?>>料理</option>
                                                    <option value="文学" <?php echo $user['preferences']['default_category'] === '文学' ? 'selected' : ''; ?>>文学</option>
                                                    <option value="文化" <?php echo $user['preferences']['default_category'] === '文化' ? 'selected' : ''; ?>>文化</option>
                                                    <option value="ニュース" <?php echo $user['preferences']['default_category'] === 'ニュース' ? 'selected' : ''; ?>>ニュース</option>
                                                    <option value="スポーツ" <?php echo $user['preferences']['default_category'] === 'スポーツ' ? 'selected' : ''; ?>>スポーツ</option>
                                                    <option value="経済" <?php echo $user['preferences']['default_category'] === '経済' ? 'selected' : ''; ?>>経済</option>
                                                    <option value="政治" <?php echo $user['preferences']['default_category'] === '政治' ? 'selected' : ''; ?>>政治</option>
                                                </select>
                                            </div>
                                        </div>
                                        
                                        <div class="mb-4">
                                            <div class="form-check form-switch">
                                                <input class="form-check-input" type="checkbox" id="save_search_history" name="save_search_history" <?php echo $user['preferences']['save_search_history'] ? 'checked' : ''; ?>>
                                                <label class="form-check-label jp-check-label" for="save_search_history">検索履歴を保存する</label>
                                            </div>
                                        </div>
                                        
                                        <h3 class="jp-preferences-section-title">通知設定</h3>
                                        
                                        <div class="mb-4">
                                            <div class="form-check form-switch">
                                                <input class="form-check-input" type="checkbox" id="notifications" name="notifications" <?php echo $user['preferences']['notifications'] ? 'checked' : ''; ?>>
                                                <label class="form-check-label jp-check-label" for="notifications">システム通知を受け取る</label>
                                            </div>
                                        </div>
                                        
                                        <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                                            <button type="submit" class="btn jp-btn jp-btn-primary">
                                                設定を保存
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            <?php endif; ?>
                            
                            <!-- Notifications Tab -->
                            <?php if($activeTab === 'notifications'): ?>
                                <div class="jp-card-header">
                                    <h1 class="jp-title">通知</h1>
                                    <div class="jp-divider">
                                        <div class="jp-divider-inner"></div>
                                    </div>
                                </div>
                                
                                <div class="jp-card-body">
                                    <?php if(count($notifications) > 0): ?>
                                        <div class="jp-notification-controls mb-3">
                                            <button id="markAllRead" class="btn jp-btn jp-btn-outline btn-sm">
                                                すべて既読にする
                                            </button>
                                        </div>
                                        
                                        <div class="jp-notification-list">
                                            <?php foreach($notifications as $notification): ?>
                                                <div class="jp-notification-item <?php echo $notification['read'] ? '' : 'jp-notification-unread'; ?>">
                                                    <div class="jp-notification-icon">
                                                        <?php if($notification['type'] === 'system'): ?>
                                                            <i class="fas fa-cog"></i>
                                                        <?php elseif($notification['type'] === 'search'): ?>
                                                            <i class="fas fa-search"></i>
                                                        <?php else: ?>
                                                            <i class="fas fa-bell"></i>
                                                        <?php endif; ?>
                                                    </div>
                                                    <div class="jp-notification-content">
                                                        <p class="jp-notification-message"><?php echo htmlspecialchars($notification['message']); ?></p>
                                                        <p class="jp-notification-date"><?php echo htmlspecialchars($notification['date']); ?></p>
                                                    </div>
                                                    <div class="jp-notification-actions">
                                                        <button class="jp-notification-mark-read btn jp-btn-icon" data-id="<?php echo $notification['id']; ?>" title="既読にする">
                                                            <i class="fas fa-check"></i>
                                                        </button>
                                                        <button class="jp-notification-delete btn jp-btn-icon" data-id="<?php echo $notification['id']; ?>" title="削除">
                                                            <i class="fas fa-times"></i>
                                                        </button>
                                                    </div>
                                                </div>
                                            <?php endforeach; ?>
                                        </div>
                                    <?php else: ?>
                                        <div class="jp-empty-state">
                                            <div class="jp-empty-state-icon">
                                                <i class="fas fa-bell-slash"></i>
                                            </div>
                                            <h3 class="jp-empty-state-title">通知はありません</h3>
                                            <p class="jp-empty-state-text">
                                                現在、新しい通知はありません。
                                            </p>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            <?php endif; ?>
                            
                            <!-- Search History Tab -->
                            <?php if($activeTab === 'history'): ?>
                                <div class="jp-card-header">
                                    <h1 class="jp-title">検索履歴</h1>
                                    <div class="jp-divider">
                                        <div class="jp-divider-inner"></div>
                                    </div>
                                </div>
                                
                                <div class="jp-card-body">
                                    <?php if(count($searchHistory) > 0): ?>
                                        <div class="jp-history-controls mb-3">
                                            <button id="clearHistory" class="btn jp-btn jp-btn-outline btn-sm">
                                                履歴をクリア
                                            </button>
                                        </div>
                                        
                                        <div class="jp-history-list">
                                            <?php foreach($searchHistory as $history): ?>
                                                <div class="jp-history-item">
                                                    <div class="jp-history-content">
                                                        <h3 class="jp-history-query">
                                                            <a href="/search_results.php?query=<?php echo urlencode($history['query']); ?>"><?php echo htmlspecialchars($history['query']); ?></a>
                                                        </h3>
                                                        <p class="jp-history-filters"><?php echo htmlspecialchars($history['filters']); ?></p>
                                                        <p class="jp-history-meta">
                                                            <span class="jp-history-date"><?php echo htmlspecialchars($history['date']); ?></span>
                                                            <span class="jp-history-results"><?php echo htmlspecialchars($history['results']); ?> 件の結果</span>
                                                        </p>
                                                    </div>
                                                    <div class="jp-history-actions">
                                                        <a href="/search_results.php?query=<?php echo urlencode($history['query']); ?>" class="btn jp-btn-icon" title="検索を再実行">
                                                            <i class="fas fa-search"></i>
                                                        </a>
                                                        <button class="jp-history-delete btn jp-btn-icon" data-id="<?php echo $history['id']; ?>" title="履歴から削除">
                                                            <i class="fas fa-times"></i>
                                                        </button>
                                                    </div>
                                                </div>
                                            <?php endforeach; ?>
                                        </div>
                                    <?php else: ?>
                                        <div class="jp-empty-state">
                                            <div class="jp-empty-state-icon">
                                                <i class="fas fa-history"></i>
                                            </div>
                                            <h3 class="jp-empty-state-title">検索履歴はありません</h3>
                                            <p class="jp-empty-state-text">
                                                まだ検索を行っていないか、履歴がクリアされています。
                                            </p>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            <?php endif; ?>
                            
                            <!-- Security Tab -->
                            <?php if($activeTab === 'security'): ?>
                                <div class="jp-card-header">
                                    <h1 class="jp-title">セキュリティ設定</h1>
                                    <div class="jp-divider">
                                        <div class="jp-divider-inner"></div>
                                    </div>
                                </div>
                                
                                <div class="jp-card-body">
                                    <form id="securityForm">
                                        <h3 class="jp-security-section-title">パスワード変更</h3>
                                        
                                        <div class="mb-4">
                                            <label for="current_password" class="form-label jp-label">現在のパスワード</label>
                                            <div class="jp-input-wrapper">
                                                <input id="current_password" type="password" class="form-control jp-input" 
                                                    name="current_password">
                                            </div>
                                        </div>
                                        
                                        <div class="mb-4">
                                            <label for="new_password" class="form-label jp-label">新しいパスワード</label>
                                            <div class="jp-input-wrapper">
                                                <input id="new_password" type="password" class="form-control jp-input" 
                                                    name="new_password">
                                            </div>
                                            <small class="form-text jp-small-text">8文字以上で、数字、大文字、小文字を含む必要があります</small>
                                        </div>
                                        
                                        <div class="mb-4">
                                            <label for="confirm_password" class="form-label jp-label">新しいパスワード（確認）</label>
                                            <div class="jp-input-wrapper">
                                                <input id="confirm_password" type="password" class="form-control jp-input" 
                                                    name="confirm_password">
                                            </div>
                                        </div>
                                        
                                        <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                                            <button type="submit" class="btn jp-btn jp-btn-primary">
                                                パスワードを変更
                                            </button>
                                        </div>
                                        
                                        <hr class="jp-divider-full my-4">
                                        
                                        <h3 class="jp-security-section-title">アカウント削除</h3>
                                        <p class="jp-security-warning">
                                            アカウントを削除すると、すべてのデータが完全に削除され、復元できなくなります。
                                        </p>
                                        
                                        <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                                            <button type="button" class="btn jp-btn jp-btn-danger" data-bs-toggle="modal" data-bs-target="#deleteAccountModal">
                                                アカウントを削除
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <!-- Delete Account Modal -->
    <div class="modal fade" id="deleteAccountModal" tabindex="-1" aria-labelledby="deleteAccountModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteAccountModalLabel">アカウント削除の確認</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>アカウントを削除すると、すべてのデータが完全に削除され、復元できなくなります。本当に削除しますか？</p>
                    <div class="form-check mb-3">
                        <input class="form-check-input" type="checkbox" id="confirmDelete">
                        <label class="form-check-label" for="confirmDelete">
                            アカウントを削除することを確認します
                        </label>
                    </div>
                    <div class="mb-3">
                        <label for="deleteReason" class="form-label">削除理由（任意）</label>
                        <textarea class="form-control" id="deleteReason" rows="3"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn jp-btn jp-btn-secondary" data-bs-dismiss="modal">キャンセル</button>
                    <button type="button" class="btn jp-btn jp-btn-danger" id="confirmDeleteBtn" disabled>アカウントを削除</button>
                </div>
            </div>
        </div>
    </div>

    <footer class="jp-footer text-center py-4">
        <div class="container">
            <div class="jp-footer-pattern"></div>
            <p>&copy; <?php echo date('Y'); ?> 日本スタイルのウェブアプリケーション. All rights reserved.</p>
        </div>
    </footer>

    <!-- Bootstrap 5 JS Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- Custom validation script -->
    <script src="js/validation.js"></script>
    
    <!-- Zen mode script -->
    <script src="js/zen-mode.js"></script>
    
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Enable delete account button only when checkbox is checked
            const confirmDeleteCheckbox = document.getElementById('confirmDelete');
            const confirmDeleteBtn = document.getElementById('confirmDeleteBtn');
            
            if (confirmDeleteCheckbox && confirmDeleteBtn) {
                confirmDeleteCheckbox.addEventListener('change', function() {
                    confirmDeleteBtn.disabled = !this.checked;
                });
            }
            
            // Handle mark all notifications as read
            const markAllReadBtn = document.getElementById('markAllRead');
            if (markAllReadBtn) {
                markAllReadBtn.addEventListener('click', function() {
                    document.querySelectorAll('.jp-notification-item').forEach(item => {
                        item.classList.remove('jp-notification-unread');
                    });
                    // In a real app, this would send an AJAX request to mark all as read
                    alert('すべての通知を既読にしました。');
                });
            }
            
            // Handle mark individual notification as read
            document.querySelectorAll('.jp-notification-mark-read').forEach(btn => {
                btn.addEventListener('click', function() {
                    const id = this.getAttribute('data-id');
                    const item = this.closest('.jp-notification-item');
                    item.classList.remove('jp-notification-unread');
                    // In a real app, this would send an AJAX request to mark as read
                    console.log('Notification ' + id + ' marked as read');
                });
            });
            
            // Handle delete notification
            document.querySelectorAll('.jp-notification-delete').forEach(btn => {
                btn.addEventListener('click', function() {
                    const id = this.getAttribute('data-id');
                    const item = this.closest('.jp-notification-item');
                    item.remove();
                    // In a real app, this would send an AJAX request to delete
                    console.log('Notification ' + id + ' deleted');
                });
            });
            
            // Handle clear search history
            const clearHistoryBtn = document.getElementById('clearHistory');
            if (clearHistoryBtn) {
                clearHistoryBtn.addEventListener('click', function() {
                    if (confirm('検索履歴をすべて削除しますか？')) {
                        document.querySelectorAll('.jp-history-item').forEach(item => {
                            item.remove();
                        });
                        
                        // Show empty state
                        const historyList = document.querySelector('.jp-history-list');
                        if (historyList) {
                            historyList.innerHTML = `
                                <div class="jp-empty-state">
                                    <div class="jp-empty-state-icon">
                                        <i class="fas fa-history"></i>
                                    </div>
                                    <h3 class="jp-empty-state-title">検索履歴はありません</h3>
                                    <p class="jp-empty-state-text">
                                        まだ検索を行っていないか、履歴がクリアされています。
                                    </p>
                                </div>
                            `;
                        }
                        
                        // In a real app, this would send an AJAX request to clear history
                        console.log('Search history cleared');
                    }
                });
            }
            
            // Handle delete history item
            document.querySelectorAll('.jp-history-delete').forEach(btn => {
                btn.addEventListener('click', function() {
                    const id = this.getAttribute('data-id');
                    const item = this.closest('.jp-history-item');
                    item.remove();
                    // In a real app, this would send an AJAX request to delete
                    console.log('History item ' + id + ' deleted');
                    
                    // Check if history is empty
                    const historyItems = document.querySelectorAll('.jp-history-item');
                    if (historyItems.length === 0) {
                        const historyList = document.querySelector('.jp-history-list');
                        if (historyList) {
                            historyList.innerHTML = `
                                <div class="jp-empty-state">
                                    <div class="jp-empty-state-icon">
                                        <i class="fas fa-history"></i>
                                    </div>
                                    <h3 class="jp-empty-state-title">検索履歴はありません</h3>
                                    <p class="jp-empty-state-text">
                                        まだ検索を行っていないか、履歴がクリアされています。
                                    </p>
                                </div>
                            `;
                        }
                    }
                });
            });
            
            // Form validation for profile form
            const profileForm = document.getElementById('profileForm');
            if (profileForm) {
                profileForm.addEventListener('submit', function(event) {
                    event.preventDefault();
                    // In a real app, this would validate and submit the form
                    alert('プロフィール情報が更新されました。');
                });
            }
            
            // Form validation for preferences form
            const preferencesForm = document.getElementById('preferencesForm');
            if (preferencesForm) {
                preferencesForm.addEventListener('submit', function(event) {
                    event.preventDefault();
                    // In a real app, this would validate and submit the form
                    alert('ユーザー設定が保存されました。');
                });
            }
            
            // Form validation for security form
            const securityForm = document.getElementById('securityForm');
            if (securityForm) {
                securityForm.addEventListener('submit', function(event) {
                    event.preventDefault();
                    
                    const currentPassword = document.getElementById('current_password').value;
                    const newPassword = document.getElementById('new_password').value;
                    const confirmPassword = document.getElementById('confirm_password').value;
                    
                    // Clear previous error messages
                    document.querySelectorAll('.jp-error-message').forEach(el => {
                        el.remove();
                    });
                    
                    let isValid = true;
                    
                    // Validate current password
                    if (!currentPassword) {
                        isValid = false;
                        const input = document.getElementById('current_password');
                        const errorMessage = document.createElement('span');
                        errorMessage.className = 'jp-error-message';
                        errorMessage.textContent = '現在のパスワードを入力してください。';
                        input.parentNode.after(errorMessage);
                    }
                    
                    // Validate new password
                    if (!newPassword) {
                        isValid = false;
                        const input = document.getElementById('new_password');
                        const errorMessage = document.createElement('span');
                        errorMessage.className = 'jp-error-message';
                        errorMessage.textContent = '新しいパスワードを入力してください。';
                        input.parentNode.after(errorMessage);
                    } else if (newPassword.length < 8) {
                        isValid = false;
                        const input = document.getElementById('new_password');
                        const errorMessage = document.createElement('span');
                        errorMessage.className = 'jp-error-message';
                        errorMessage.textContent = 'パスワードは8文字以上である必要があります。';
                        input.parentNode.after(errorMessage);
                    }
                    
                    // Validate password confirmation
                    if (newPassword !== confirmPassword) {
                        isValid = false;
                        const input = document.getElementById('confirm_password');
                        const errorMessage = document.createElement('span');
                        errorMessage.className = 'jp-error-message';
                        errorMessage.textContent = 'パスワードが一致しません。';
                        input.parentNode.after(errorMessage);
                    }
                    
                    if (isValid) {
                        // In a real app, this would validate and submit the form
                        alert('パスワードが変更されました。');
                        securityForm.reset();
                    }
                });
            }
            
            // Handle account deletion
            const confirmDeleteButton = document.getElementById('confirmDeleteBtn');
            if (confirmDeleteButton) {
                confirmDeleteButton.addEventListener('click', function() {
                    // In a real app, this would send a request to delete the account
                    alert('アカウントが削除されました。ログイン画面に戻ります。');
                    window.location.href = '/login.php';
                });
            }
        });
    </script>
</body>
</html>