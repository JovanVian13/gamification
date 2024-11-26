@extends('layouts.app')

@section('content')
<!-- Hero Section -->
<section class="hero-section">
    <div class="">
        <h1>Welcome to Our Gamification Platform</h1>
        <p>Earn reward points by completing tasks and redeem them for shopping vouchers!</p>
        <a href="{{ route('register') }}" class="cta-button">Join Now</a>
    </div>
</section>

<!-- About Section -->
<section class="container my-5">
    <div class="section-title m-p-secondary">
        <h2>What is Gamification?</h2>
        <p>Engage with exciting tasks, earn points, and unlock amazing rewards.</p>
    </div>
    <div class="row">
        <div class="col-md-4">
            <div class="card feature-card m-bg-primary">
                <div class="card-body text-center m-p-secondary">
                    <i class="fas fa-video fa-4x mb-3"></i>
                    <h4 class="card-title">Watch Videos</h4>
                    <p>Earn points by watching videos to completion.</p>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card feature-card m-bg-primary">
                <div class="card-body text-center m-p-secondary">
                    <i class="fas fa-thumbs-up fa-4x mb-3"></i>
                    <h4 class="card-title">Like Videos</h4>
                    <p>Give likes to videos and receive points.</p>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card feature-card m-bg-primary">
                <div class="card-body text-center m-p-secondary">
                    <i class="fas fa-share fa-4x mb-3"></i>
                    <h4 class="card-title">Share Videos</h4>
                    <p>Share content on social media to earn more points.</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Rewards Section -->
<section class="container my-5">
    <div class="text-center mb-4 m-p-secondary">
        <h2>How to Redeem Your Points</h2>
    </div>
    <div class="row text-center g-4">
        <div class="col-md-4">
            <div class="card h-100">
                <div class="card-body d-flex flex-column align-items-center">
                    <img src="../../assets/img/poin.png" alt="Earn Points" class="img-fluid mb-3 rounded">
                    <h5 class="card-title m-p-secondary">Earn Points</h5>
                    <p class="card-text">Complete simple tasks and collect reward points.</p>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card h-100">
                <div class="card-body d-flex flex-column align-items-center">
                    <img src="../../assets/img/voucher.png" alt="Convert to Vouchers" class="img-fluid mb-3 rounded">
                    <h5 class="card-title m-p-secondary">Convert to Vouchers</h5>
                    <p class="card-text">Exchange your points for shopping vouchers!</p>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card h-100">
                <div class="card-body d-flex flex-column align-items-center">
                    <img src="../../assets/img/poin.png" alt="Shop and Enjoy" class="img-fluid mb-3 rounded">
                    <h5 class="card-title m-p-secondary">Shop and Enjoy</h5>
                    <p class="card-text">Use your vouchers to shop your favorite products.</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Testimonials Section -->
<section class="container my-5">
    <div class="section-title m-p-secondary">
        <h2>What Our Users Say</h2>
    </div>
    <div class="row">
        <div class="col-md-4">
            <div class="card feature-card">
                <div class="card-body text-center">
                    <p>"This platform is amazing! I’ve earned so many rewards just by watching videos!"</p>
                    <h5>- User 1</h5>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card feature-card">
                <div class="card-body text-center">
                    <p>"I love how easy it is to earn points and convert them into vouchers."</p>
                    <h5>- User 2</h5>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card feature-card">
                <div class="card-body text-center">
                    <p>"The tasks are fun and I enjoy competing on the leaderboard!"</p>
                    <h5>- User 3</h5>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
