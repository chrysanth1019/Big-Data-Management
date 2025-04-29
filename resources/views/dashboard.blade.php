<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>データサービス - Japanese Data Service</title>
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans+JP:wght@300;400;500;700&family=Shippori+Mincho:wght@400;500;700&display=swap" rel="stylesheet">
    
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    
    <!-- AOS - Animate On Scroll Library -->
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    
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
            --jp-blue: #4A6FA5;
            --jp-dark-blue: #365785;
            --jp-light-blue: #EBF2FA;
        }
        
        body {
            font-family: 'Noto Sans JP', sans-serif;
            background-color: #FFFFFF;
            color: #333;
            padding-top: 76px; /* For fixed navbar */
            position: relative;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }
        
        /* Navbar styles */
        .jp-navbar {
            background-color: white;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
            padding: 0.5rem 1rem;
            position: fixed;
            top: 0;
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
        
        /* Hero section */
        .hero-section {
            background: linear-gradient(135deg, var(--jp-light-blue) 0%, #F8F9FA 100%);
            padding: 6rem 0;
            position: relative;
            overflow: hidden;
        }
        
        .hero-section::before {
            content: '';
            position: absolute;
            top: -5%;
            right: -5%;
            width: 300px;
            height: 300px;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='100' height='100' viewBox='0 0 100 100'%3E%3Cpath fill='%234A6FA5' fill-opacity='0.05' d='M11 18c3.866 0 7-3.134 7-7s-3.134-7-7-7-7 3.134-7 7 3.134 7 7 7zm48 25c3.866 0 7-3.134 7-7s-3.134-7-7-7-7 3.134-7 7 3.134 7 7 7zm-43-7c1.657 0 3-1.343 3-3s-1.343-3-3-3-3 1.343-3 3 1.343 3 3 3zm63 31c1.657 0 3-1.343 3-3s-1.343-3-3-3-3 1.343-3 3 1.343 3 3 3zM34 90c1.657 0 3-1.343 3-3s-1.343-3-3-3-3 1.343-3 3 1.343 3 3 3zm56-76c1.657 0 3-1.343 3-3s-1.343-3-3-3-3 1.343-3 3 1.343 3 3 3zM12 86c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm28-65c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm23-11c2.76 0 5-2.24 5-5s-2.24-5-5-5-5 2.24-5 5 2.24 5 5 5zm-6 60c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm29 22c2.76 0 5-2.24 5-5s-2.24-5-5-5-5 2.24-5 5 2.24 5 5 5zM32 63c2.76 0 5-2.24 5-5s-2.24-5-5-5-5 2.24-5 5 2.24 5 5 5zm57-13c2.76 0 5-2.24 5-5s-2.24-5-5-5-5 2.24-5 5 2.24 5 5 5zm-9-21c1.105 0 2-.895 2-2s-.895-2-2-2-2 .895-2 2 .895 2 2 2zM60 91c1.105 0 2-.895 2-2s-.895-2-2-2-2 .895-2 2 .895 2 2 2zM35 41c1.105 0 2-.895 2-2s-.895-2-2-2-2 .895-2 2 .895 2 2 2zM12 60c1.105 0 2-.895 2-2s-.895-2-2-2-2 .895-2 2 .895 2 2 2z'%3E%3C/path%3E%3C/svg%3E");
            z-index: 0;
            opacity: 0.6;
            transform: rotate(10deg);
        }
        
        .hero-title {
            font-family: 'Shippori Mincho', serif;
            font-size: 3rem;
            font-weight: 700;
            color: var(--jp-navy);
            margin-bottom: 1.5rem;
            line-height: 1.2;
        }
        
        .hero-subtitle {
            font-size: 1.3rem;
            color: #555;
            margin-bottom: 2rem;
            line-height: 1.6;
        }
        
        .hero-image {
            max-width: 100%;
            border-radius: 8px;
            box-shadow: 0 15px 30px rgba(0, 0, 0, 0.1);
        }
        
        /* Features section */
        .features-section {
            padding: 5rem 0;
            background-color: white;
        }
        
        .section-title {
            font-family: 'Shippori Mincho', serif;
            font-size: 2.2rem;
            color: var(--jp-navy);
            margin-bottom: 1.5rem;
            text-align: center;
            position: relative;
            padding-bottom: 1rem;
        }
        
        .section-title::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 50%;
            transform: translateX(-50%);
            width: 80px;
            height: 3px;
            background: linear-gradient(to right, var(--jp-blue), var(--jp-gold));
            border-radius: 3px;
        }
        
        .feature-card {
            background-color: white;
            border-radius: 8px;
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.05);
            padding: 2rem;
            height: 100%;
            transition: all 0.3s;
            position: relative;
            overflow: hidden;
            border: 1px solid #f0f0f0;
        }
        
        .feature-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 5px;
            height: 100%;
            background: linear-gradient(to bottom, var(--jp-blue), var(--jp-light-blue));
        }
        
        .feature-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 30px rgba(0, 0, 0, 0.1);
        }
        
        .feature-icon {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 60px;
            height: 60px;
            border-radius: 50%;
            background-color: rgba(74, 111, 165, 0.1);
            color: var(--jp-blue);
            font-size: 1.5rem;
            margin-bottom: 1.5rem;
        }
        
        .feature-title {
            font-weight: 600;
            font-size: 1.3rem;
            color: var(--jp-navy);
            margin-bottom: 1rem;
        }
        
        .feature-text {
            color: #555;
            line-height: 1.7;
            margin-bottom: 1rem;
        }
        
        /* Call to action section */
        .cta-section {
            padding: 5rem 0;
            background: linear-gradient(135deg, var(--jp-navy) 0%, var(--jp-dark-navy) 100%);
            color: white;
            position: relative;
            overflow: hidden;
        }
        
        .cta-section::before {
            content: '';
            position: absolute;
            top: 0;
            right: 0;
            width: 300px;
            height: 300px;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='100' height='100' viewBox='0 0 100 100'%3E%3Cpath fill='%23FFFFFF' fill-opacity='0.05' d='M11 18c3.866 0 7-3.134 7-7s-3.134-7-7-7-7 3.134-7 7 3.134 7 7 7zm48 25c3.866 0 7-3.134 7-7s-3.134-7-7-7-7 3.134-7 7 3.134 7 7 7zm-43-7c1.657 0 3-1.343 3-3s-1.343-3-3-3-3 1.343-3 3 1.343 3 3 3zm63 31c1.657 0 3-1.343 3-3s-1.343-3-3-3-3 1.343-3 3 1.343 3 3 3zM34 90c1.657 0 3-1.343 3-3s-1.343-3-3-3-3 1.343-3 3 1.343 3 3 3zm56-76c1.657 0 3-1.343 3-3s-1.343-3-3-3-3 1.343-3 3 1.343 3 3 3zM12 86c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm28-65c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm23-11c2.76 0 5-2.24 5-5s-2.24-5-5-5-5 2.24-5 5 2.24 5 5 5zm-6 60c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm29 22c2.76 0 5-2.24 5-5s-2.24-5-5-5-5 2.24-5 5 2.24 5 5 5zM32 63c2.76 0 5-2.24 5-5s-2.24-5-5-5-5 2.24-5 5 2.24 5 5 5zm57-13c2.76 0 5-2.24 5-5s-2.24-5-5-5-5 2.24-5 5 2.24 5 5 5zm-9-21c1.105 0 2-.895 2-2s-.895-2-2-2-2 .895-2 2 .895 2 2 2zM60 91c1.105 0 2-.895 2-2s-.895-2-2-2-2 .895-2 2 .895 2 2 2zM35 41c1.105 0 2-.895 2-2s-.895-2-2-2-2 .895-2 2 .895 2 2 2zM12 60c1.105 0 2-.895 2-2s-.895-2-2-2-2 .895-2 2 .895 2 2 2z'%3E%3C/path%3E%3C/svg%3E");
            z-index: 0;
            opacity: 0.3;
        }
        
        .cta-title {
            font-family: 'Shippori Mincho', serif;
            font-size: 2.5rem;
            font-weight: 600;
            margin-bottom: 1.5rem;
        }
        
        .cta-text {
            font-size: 1.2rem;
            margin-bottom: 2rem;
            opacity: 0.9;
        }
        
        /* Button styles */
        .btn-jp-primary {
            background-color: var(--jp-blue);
            border: none;
            color: white;
            padding: 0.8rem 2rem;
            border-radius: 4px;
            box-shadow: 0 4px 6px rgba(74, 111, 165, 0.2);
            transition: all 0.3s;
            font-weight: 500;
            letter-spacing: 0.03em;
            position: relative;
            overflow: hidden;
        }
        
        .btn-jp-primary::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
            transition: all 0.4s ease;
        }
        
        .btn-jp-primary:hover {
            background-color: var(--jp-dark-blue);
            transform: translateY(-2px);
            box-shadow: 0 6px 10px rgba(74, 111, 165, 0.25);
            color: white;
        }
        
        .btn-jp-primary:hover::before {
            left: 100%;
        }
        
        .btn-jp-secondary {
            background-color: transparent;
            border: 2px solid white;
            color: white;
            padding: 0.8rem 2rem;
            border-radius: 4px;
            transition: all 0.3s;
            font-weight: 500;
            letter-spacing: 0.03em;
        }
        
        .btn-jp-secondary:hover {
            background-color: white;
            color: var(--jp-navy);
            transform: translateY(-2px);
        }
        
        /* Footer */
        .jp-footer {
            background-color: var(--jp-navy);
            color: white;
            padding: 4rem 0 0;
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
            margin-bottom: 1.5rem;
            opacity: 0.8;
            line-height: 1.7;
        }
        
        .footer-link {
            color: rgba(255, 255, 255, 0.8);
            display: block;
            margin-bottom: 0.8rem;
            transition: all 0.3s;
            text-decoration: none;
        }
        
        .footer-link:hover {
            color: white;
            transform: translateX(5px);
        }
        
        .footer-link i {
            margin-right: 0.5rem;
            color: var(--jp-gold);
        }
        
        .footer-social {
            display: flex;
            gap: 1rem;
            margin-top: 1.5rem;
        }
        
        .social-link {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 38px;
            height: 38px;
            border-radius: 50%;
            background-color: rgba(255, 255, 255, 0.1);
            color: white;
            transition: all 0.3s;
        }
        
        .social-link:hover {
            background-color: var(--jp-gold);
            color: white;
            transform: translateY(-3px);
        }
        
        .copyright {
            background-color: rgba(0, 0, 0, 0.2);
            padding: 1.5rem 0;
            margin-top: 3rem;
            text-align: center;
            font-size: 0.9rem;
            opacity: 0.7;
        }
        
        /* Responsive adjustments */
        @media (max-width: 992px) {
            .hero-title {
                font-size: 2.5rem;
            }
            
            .hero-section {
                padding: 4rem 0;
            }
            
            .hero-image {
                margin-top: 2rem;
            }
        }
        
        @media (max-width: 768px) {
            .jp-navbar {
                padding: 0.5rem 1rem;
            }
            
            .logo-text {
                font-size: 1.2rem;
            }
            
            .hero-title {
                font-size: 2rem;
            }
            
            .hero-subtitle {
                font-size: 1.1rem;
            }
            
            .section-title {
                font-size: 1.8rem;
            }
            
            .feature-card {
                margin-bottom: 1.5rem;
            }
            
            .cta-title {
                font-size: 2rem;
            }
            
            .jp-footer {
                padding: 3rem 0 0;
            }
            
            .footer-column {
                margin-bottom: 2rem;
            }
        }
        
        /* Animation classes */
        .jp-fade-in {
            animation: fadein 0.8s;
        }
        
        @keyframes fadein {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
    </style>
</head>
<body>
    <!-- Navigation -->
    @include('partials.topbar')

    <!-- Hero Section -->
    <section class="hero-section">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6" data-aos="fade-right" data-aos-duration="1000">
                    <h1 class="hero-title">データ分析で<br>ビジネスの未来を描く</h1>
                    <p class="hero-subtitle">高速検索が可能なデータサービスです。<br>必要な情報を迅速に検索し、すぐに閲覧できます。</p>
                    <div class="d-flex flex-wrap gap-2">
                        <a href="#features" class="btn btn-jp-primary">
                            <i class="bi bi-arrow-right-circle me-2"></i>詳細を見る
                        </a>
                    </div>
                </div>
                <div class="col-lg-6" data-aos="fade-left" data-aos-duration="1000" data-aos-delay="200">
                    <img src="https://images.unsplash.com/photo-1551288049-bebda4e38f71?auto=format&fit=crop&q=80&w=2340&ixlib=rb-4.0.3" 
                         alt="Data Analytics Dashboard" class="hero-image">
                </div>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section class="features-section" id="features">
        <div class="container">
            <h2 class="section-title" data-aos="fade-up">主な機能</h2>
            <p class="text-center mb-5" data-aos="fade-up" data-aos-delay="100">
                当社のデータサービスが提供する先進的な機能をご紹介します
            </p>
            
            <div class="row g-4">
                <div class="col-md-4" data-aos="fade-up" data-aos-delay="100">
                    <div class="feature-card">
                        <div class="feature-icon">
                            <i class="bi bi-graph-up"></i>
                        </div>
                        <h3 class="feature-title">リアルタイム分析</h3>
                        <p class="feature-text">データをリアルタイムで分析し、瞬時に意思決定に役立つインサイトを提供します。時間の経過とともに変化するトレンドを逃しません。</p>
                        <a href="#" class="btn btn-sm btn-outline-primary">詳細を見る <i class="bi bi-arrow-right ms-1"></i></a>
                    </div>
                </div>
                
                <div class="col-md-4" data-aos="fade-up" data-aos-delay="200">
                    <div class="feature-card">
                        <div class="feature-icon">
                            <i class="bi bi-shield-lock"></i>
                        </div>
                        <h3 class="feature-title">高度なセキュリティ</h3>
                        <p class="feature-text">最先端の暗号化技術とセキュリティプロトコルにより、お客様の大切なデータを守ります。安心してご利用いただけます。</p>
                        <a href="#" class="btn btn-sm btn-outline-primary">詳細を見る <i class="bi bi-arrow-right ms-1"></i></a>
                    </div>
                </div>
                
                <div class="col-md-4" data-aos="fade-up" data-aos-delay="300">
                    <div class="feature-card">
                        <div class="feature-icon">
                            <i class="bi bi-cloud-arrow-up"></i>
                        </div>
                        <h3 class="feature-title">クラウド統合</h3>
                        <p class="feature-text">主要なクラウドサービスとシームレスに統合し、場所や時間を問わずデータにアクセスできます。ビジネスの柔軟性を高めます。</p>
                        <a href="#" class="btn btn-sm btn-outline-primary">詳細を見る <i class="bi bi-arrow-right ms-1"></i></a>
                    </div>
                </div>
            </div>
        </div>
    </section>
    
    <!-- Services Section -->
    <section class="features-section bg-light" id="services">
        <div class="container">
            <h2 class="section-title" data-aos="fade-up">サービス内容</h2>
            <p class="text-center mb-5" data-aos="fade-up" data-aos-delay="100">
                あらゆる規模のビジネスに対応する包括的なデータサービスをご提供します
            </p>
            
            <div class="row g-4">
                <div class="col-lg-6" data-aos="fade-up" data-aos-delay="100">
                    <div class="feature-card">
                        <div class="feature-icon">
                            <i class="bi bi-database"></i>
                        </div>
                        <h3 class="feature-title">データ統合・管理</h3>
                        <p class="feature-text">複数のソースからデータを収集し、統合・クレンジングを行います。一元化されたデータ環境を構築し、分析の基盤を整えます。</p>
                        <ul class="list-unstyled mt-3">
                            <li><i class="bi bi-check-circle-fill text-success me-2"></i>マルチソースデータ統合</li>
                            <li><i class="bi bi-check-circle-fill text-success me-2"></i>データクレンジング</li>
                            <li><i class="bi bi-check-circle-fill text-success me-2"></i>エンティティ解決</li>
                        </ul>
                    </div>
                </div>
                
                <div class="col-lg-6" data-aos="fade-up" data-aos-delay="200">
                    <div class="feature-card">
                        <div class="feature-icon">
                            <i class="bi bi-bar-chart"></i>
                        </div>
                        <h3 class="feature-title">ビジネスインテリジェンス</h3>
                        <p class="feature-text">データを可視化し、ビジネス意思決定に役立つインサイトを抽出します。直感的なダッシュボードで複雑なデータも簡単に理解できます。</p>
                        <ul class="list-unstyled mt-3">
                            <li><i class="bi bi-check-circle-fill text-success me-2"></i>インタラクティブダッシュボード</li>
                            <li><i class="bi bi-check-circle-fill text-success me-2"></i>カスタムレポート作成</li>
                            <li><i class="bi bi-check-circle-fill text-success me-2"></i>KPI追跡と分析</li>
                        </ul>
                    </div>
                </div>
                
                <div class="col-lg-6" data-aos="fade-up" data-aos-delay="300">
                    <div class="feature-card">
                        <div class="feature-icon">
                            <i class="bi bi-robot"></i>
                        </div>
                        <h3 class="feature-title">予測分析・機械学習</h3>
                        <p class="feature-text">過去のデータから将来のトレンドを予測し、プロアクティブな意思決定を可能にします。高度なアルゴリズムでビジネスチャンスを発見します。</p>
                        <ul class="list-unstyled mt-3">
                            <li><i class="bi bi-check-circle-fill text-success me-2"></i>需要予測</li>
                            <li><i class="bi bi-check-circle-fill text-success me-2"></i>顧客セグメンテーション</li>
                            <li><i class="bi bi-check-circle-fill text-success me-2"></i>異常検知</li>
                        </ul>
                    </div>
                </div>
                
                <div class="col-lg-6" data-aos="fade-up" data-aos-delay="400">
                    <div class="feature-card">
                        <div class="feature-icon">
                            <i class="bi bi-people"></i>
                        </div>
                        <h3 class="feature-title">コンサルティング・トレーニング</h3>
                        <p class="feature-text">データ戦略の策定から社内チームのトレーニングまで、包括的なサポートを提供します。データドリブンな組織文化の構築をお手伝いします。</p>
                        <ul class="list-unstyled mt-3">
                            <li><i class="bi bi-check-circle-fill text-success me-2"></i>データ戦略コンサルティング</li>
                            <li><i class="bi bi-check-circle-fill text-success me-2"></i>技術トレーニング</li>
                            <li><i class="bi bi-check-circle-fill text-success me-2"></i>組織変革支援</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>
    
    
    <!-- Footer -->
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
                    <h3 class="footer-title">サービス</h3>
                    <a href="#" class="footer-link"><i class="bi bi-chevron-right"></i>データ統合</a>
                    <a href="#" class="footer-link"><i class="bi bi-chevron-right"></i>分析・可視化</a>
                    <a href="#" class="footer-link"><i class="bi bi-chevron-right"></i>予測分析</a>
                    <a href="#" class="footer-link"><i class="bi bi-chevron-right"></i>データセキュリティ</a>
                </div>
                
                <div class="col-lg-2 col-md-4 mb-4 mb-md-0">
                    <h3 class="footer-title">リンク</h3>
                    <a href="#" class="footer-link"><i class="bi bi-chevron-right"></i>ホーム</a>
                    <a href="#" class="footer-link"><i class="bi bi-chevron-right"></i>機能</a>
                    <a href="#" class="footer-link"><i class="bi bi-chevron-right"></i>サービス</a>
                    <a href="#" class="footer-link"><i class="bi bi-chevron-right"></i>会社情報</a>
                </div>
                
                <div class="col-lg-4 col-md-4">
                    <h3 class="footer-title">お問い合わせ</h3>
                    <p class="footer-text">
                        <i class="bi bi-geo-alt me-2"></i> 〒103-0027 東京都中央区日本橋1-1-1
                    </p>
                    <p class="footer-text">
                        <i class="bi bi-envelope me-2"></i> info@dataservice.jp
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
    
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- AOS - Animate On Scroll Library -->
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    
    <script>
        // Initialize AOS
        AOS.init({
            once: true,
            duration: 800
        });
        
        // Navbar scroll effect
        window.addEventListener('scroll', function() {
            const navbar = document.querySelector('.jp-navbar');
            if (window.scrollY > 50) {
                navbar.classList.add('scrolled');
            } else {
                navbar.classList.remove('scrolled');
            }
        });
        
        // Smooth scrolling for anchor links
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function(e) {
                e.preventDefault();
                
                const targetId = this.getAttribute('href');
                if (targetId === '#') return;
                
                const targetElement = document.querySelector(targetId);
                if (targetElement) {
                    window.scrollTo({
                        top: targetElement.offsetTop - 80,
                        behavior: 'smooth'
                    });
                }
            });
        });
    </script>
    
    <!-- Search Modal -->
    <div class="modal fade" id="searchModal" tabindex="-1" aria-labelledby="searchModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header border-0">
                    <h5 class="modal-title" id="searchModalLabel">
                        <i class="bi bi-search me-2"></i>検索
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="#" method="GET">
                        <div class="input-group mb-3">
                            <input type="text" class="form-control form-control-lg" placeholder="キーワードを入力..." aria-label="Search">
                            <button class="btn btn-jp-primary" type="submit">
                                <i class="bi bi-search"></i>
                            </button>
                        </div>
                        <div class="form-text text-muted mb-3">
                            データ分析、クラウド統合、セキュリティなどのキーワードで検索できます
                        </div>
                        <div class="d-flex flex-wrap gap-2">
                            <a href="#" class="badge bg-light text-dark text-decoration-none p-2">データ分析</a>
                            <a href="#" class="badge bg-light text-dark text-decoration-none p-2">BI</a>
                            <a href="#" class="badge bg-light text-dark text-decoration-none p-2">機械学習</a>
                            <a href="#" class="badge bg-light text-dark text-decoration-none p-2">クラウド</a>
                            <a href="#" class="badge bg-light text-dark text-decoration-none p-2">セキュリティ</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>
</html>