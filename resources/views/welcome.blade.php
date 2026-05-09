<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Campus Food Stall - Order Ahead</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/premium.css') }}">
    <style>
        .hero {
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            text-align: center;
            padding: 2rem;
        }
        .hero-content h1 {
            font-size: 4rem;
            margin-bottom: 1rem;
            background: linear-gradient(to right, #fff, var(--primary));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            font-weight: 800;
        }
        .hero-content p {
            font-size: 1.25rem;
            color: var(--text-muted);
            max-width: 600px;
            margin: 0 auto 2rem;
        }
        .nav-fixed {
            position: fixed;
            top: 0;
            width: 100%;
            padding: 1.5rem 4rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
            z-index: 100;
            backdrop-filter: blur(10px);
            background: rgba(15, 23, 42, 0.3);
        }
        .logo {
            font-size: 1.5rem;
            font-weight: 700;
            color: white;
        }
        .logo span { color: var(--primary); }
        
        .feature-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 2rem;
            padding: 4rem;
            max-width: 1200px;
            margin: 0 auto;
        }
        .feature-card {
            text-align: left;
        }
        .feature-card h3 {
            color: var(--primary);
            margin-bottom: 0.5rem;
        }
    </style>
</head>
<body>
    <nav class="nav-fixed">
        <div class="logo">Campus<span>Food</span></div>
        <div class="nav-links">
            @if (Route::has('login'))
                @auth
                    <a href="{{ url('/dashboard') }}" class="premium-btn">Dashboard</a>
                @else
                    <a href="{{ route('login') }}" style="color: white; margin-right: 1.5rem; font-weight: 500;">Log in</a>
                    @if (Route::has('register'))
                        <a href="{{ route('register') }}" class="premium-btn">Join Now</a>
                    @endif
                @endauth
            @endif
        </div>
    </nav>

    <section class="hero">
        <div class="hero-content">
            <h1>Skip the Queue,<br>Enjoy the Taste.</h1>
            <p>The smartest way to order from your favorite campus food stalls. Pre-order, track, and pick up when it's ready.</p>
            <div style="display: flex; gap: 1rem; justify-content: center;">
                <a href="{{ route('register') }}" class="premium-btn">Start Ordering</a>
                <a href="#features" class="premium-btn" style="background: rgba(255,255,255,0.1); backdrop-filter: blur(5px);">Learn More</a>
            </div>
        </div>
    </section>

    <section id="features" class="feature-grid">
        <div class="premium-card feature-card">
            <h3>Pre-Order System</h3>
            <p>Browse menus from all stalls and place your order before you even reach the canteen.</p>
        </div>
        <div class="premium-card feature-card">
            <h3>Live Tracking</h3>
            <p>Get real-time updates on your order status. We'll tell you exactly when it's ready for pickup.</p>
        </div>
        <div class="premium-card feature-card">
            <h3>Easy Management</h3>
            <p>Stall owners can manage menus, track sales, and handle orders from a single dashboard.</p>
        </div>
    </section>

    <footer style="text-align: center; padding: 4rem; color: var(--text-muted);">
        <p>&copy; 2026 Campus Food Stall Ordering System. Built with Premium aesthetics.</p>
    </footer>
</body>
</html>
