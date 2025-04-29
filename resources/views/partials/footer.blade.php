<footer class="jp-footer">
    <div class="container">
        <div class="row">
            <div class="col-lg-4 mb-4 mb-lg-0">
                <div class="d-flex align-items-center mb-3">
                    <img src="{{ asset('images/logo.svg') }}" alt="データサービス" width="80" height="40">
                    <h3 class="footer-title mb-0 ms-2">データサービス</h3>
                </div>
                <p class="footer-text">
                    最先端のデータ分析・管理ソリューションを提供し、あらゆる業界のビジネスの成長と革新をサポートしています。
                </p>
                <div class="footer-social">
                    <a href="#" class="social-link"><i class="bi bi-twitter"></i></a>
                    <a href="#" class="social-link"><i class="bi bi-facebook"></i></a>
                    <a href="#" class="social-link"><i class="bi bi-linkedin"></i></a>
                    <a href="#" class="social-link"><i class="bi bi-instagram"></i></a>
                </div>
            </div>
            
            <div class="col-lg-2 col-md-4 mb-4 mb-md-0">
                <h3 class="footer-title">メニュー</h3>
                <a href="/" class="footer-link"><i class="bi bi-chevron-right"></i>ホーム</a>
                <a href="{{ route('search.index') }}" class="footer-link"><i class="bi bi-chevron-right"></i>高度な検索</a>
                <a href="/simple-search" class="footer-link"><i class="bi bi-chevron-right"></i>シンプル検索</a>
                <a href="{{ route('login') }}" class="footer-link"><i class="bi bi-chevron-right"></i>ログイン</a>
            </div>
            
            <div class="col-lg-2 col-md-4 mb-4 mb-md-0">
                <h3 class="footer-title">サービス</h3>
                <a href="#" class="footer-link"><i class="bi bi-chevron-right"></i>データ統合</a>
                <a href="#" class="footer-link"><i class="bi bi-chevron-right"></i>分析・可視化</a>
                <a href="#" class="footer-link"><i class="bi bi-chevron-right"></i>予測分析</a>
                <a href="#" class="footer-link"><i class="bi bi-chevron-right"></i>データセキュリティ</a>
            </div>
            
            <div class="col-lg-4 col-md-4">
                <h3 class="footer-title">お問い合わせ</h3>
                <p class="footer-text">
                    <i class="bi bi-geo-alt me-2"></i> 〒103-0027 東京都中央区日本橋1-1-1
                </p>
                <p class="footer-text">
                    <i class="bi bi-envelope me-2"></i> info@data-service.example.jp
                </p>
                <p class="footer-text">
                    <i class="bi bi-telephone me-2"></i> 03-1234-5678
                </p>
            </div>
        </div>
    </div>
    
    <div class="copyright">
        <div class="container">
            &copy; {{ date('Y') }} データサービス. All rights reserved.
            <div class="mt-2">
                <a href="{{ route('login') }}" class="text-white text-decoration-none">管理者ログイン</a>
            </div>
        </div>
    </div>
</footer>

<style>
    /* Footer styles */
    .jp-footer {
        background-color: var(--jp-navy);
        color: white;
        padding: 3rem 0 0;
        margin-top: auto;
    }
    
    .footer-title {
        font-family: 'Shippori Mincho', serif;
        font-size: 1.2rem;
        margin-bottom: 1.5rem;
        position: relative;
        padding-bottom: 0.5rem;
    }
    
    .footer-title::after {
        content: '';
        position: absolute;
        bottom: 0;
        left: 0;
        width: 40px;
        height: 2px;
        background-color: var(--jp-gold);
    }
    
    .footer-text {
        color: rgba(255, 255, 255, 0.8);
        line-height: 1.6;
        margin-bottom: 1rem;
    }
    
    .footer-social {
        display: flex;
        gap: 0.5rem;
        margin-top: 1.5rem;
    }
    
    .social-link {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 36px;
        height: 36px;
        border-radius: 50%;
        background-color: rgba(255, 255, 255, 0.1);
        color: white;
        transition: all 0.3s;
    }
    
    .social-link:hover {
        background-color: var(--jp-gold);
        transform: translateY(-3px);
        color: white;
    }
    
    .footer-link {
        color: rgba(255, 255, 255, 0.8);
        display: block;
        margin-bottom: 0.75rem;
        transition: all 0.3s;
        text-decoration: none;
    }
    
    .footer-link i {
        margin-right: 0.5rem;
        font-size: 0.75rem;
    }
    
    .footer-link:hover {
        color: white;
        transform: translateX(5px);
    }
    
    .copyright {
        background-color: rgba(0, 0, 0, 0.2);
        padding: 1.5rem 0;
        margin-top: 3rem;
        text-align: center;
        font-size: 0.9rem;
        opacity: 0.7;
    }
</style>