@extends('layouts.app')
@section('title', 'Welcome to CareerHub')

@section('content')

{{-- ===== HERO ===== --}}
<section class="hero-section">
    <div class="container">
        <div class="row align-items-center" style="min-height:88vh">
            <div class="col-lg-6 py-5">
                <div class="d-inline-flex align-items-center gap-2 badge-pill-soft mb-4">
                    <span class="live-dot"></span>
                    <span class="small fw-semibold text-primary">50 new jobs posted today</span>
                </div>
                <h1 class="hero-title fw-bold lh-sm mb-4">
                    Find Your Dream<br>
                    <span class="text-gradient">Internship & Job</span>
                </h1>
                <p class="lead text-muted mb-4" style="max-width:480px">
                    Connect with top companies, discover opportunities, and launch your career — the platform built for Filipino students and professionals.
                </p>
                <div class="d-flex flex-wrap gap-3 mb-5">
                    <a href="{{ route('register') }}" class="btn btn-primary btn-lg rounded-pill px-5 shadow-primary">
                        <i class="fas fa-rocket me-2"></i>Get Started Free
                    </a>
                    <a href="{{ route('internships') }}" class="btn btn-outline-primary btn-lg rounded-pill px-4">
                        <i class="fas fa-search me-2"></i>Browse Jobs
                    </a>
                </div>
                <div class="d-flex gap-4 flex-wrap">
                    @foreach([['500+','Job Listings'],['200+','Companies'],['10K+','Students Hired']] as $s)
                    <div>
                        <div class="fw-bold fs-4 text-primary lh-1">{{ $s[0] }}</div>
                        <div class="text-muted small">{{ $s[1] }}</div>
                    </div>
                    @endforeach
                </div>
            </div>

            <div class="col-lg-6 py-5 d-flex justify-content-center">
                <div class="hero-visual position-relative">
                    {{-- Main SVG --}}
                    <div class="hero-svg-wrap">
                        <svg viewBox="0 0 420 380" xmlns="http://www.w3.org/2000/svg">
                            <circle cx="210" cy="190" r="175" fill="#eef2ff"/>
                            <circle cx="210" cy="190" r="130" fill="#e0e7ff" opacity=".5"/>
                            {{-- Laptop --}}
                            <rect x="110" y="155" width="200" height="130" rx="14" fill="#fff" stroke="#c7d2fe" stroke-width="2"/>
                            <rect x="110" y="155" width="200" height="42" rx="14" fill="#4f46e5"/>
                            <rect x="110" y="177" width="200" height="20" fill="#4f46e5"/>
                            <circle cx="135" cy="176" r="6" fill="#818cf8"/>
                            <circle cx="155" cy="176" r="6" fill="#a5b4fc"/>
                            <circle cx="175" cy="176" r="6" fill="#c7d2fe"/>
                            <rect x="125" y="210" width="170" height="9" rx="4" fill="#e0e7ff"/>
                            <rect x="125" y="228" width="120" height="8" rx="4" fill="#e0e7ff"/>
                            <rect x="125" y="246" width="80" height="26" rx="8" fill="#4f46e5"/>
                            <text x="165" y="264" fill="white" font-size="11" text-anchor="middle" font-family="Inter,sans-serif" font-weight="600">Apply Now</text>
                            <rect x="95" y="285" width="230" height="10" rx="5" fill="#c7d2fe"/>
                            <rect x="130" y="295" width="160" height="18" rx="9" fill="#e0e7ff"/>
                            {{-- Person --}}
                            <circle cx="210" cy="108" r="26" fill="#fbbf24"/>
                            <rect x="186" y="136" width="48" height="58" rx="12" fill="#4f46e5"/>
                            <rect x="168" y="141" width="18" height="44" rx="9" fill="#4f46e5"/>
                            <rect x="234" y="141" width="18" height="44" rx="9" fill="#4f46e5"/>
                            <rect x="191" y="194" width="16" height="48" rx="8" fill="#312e81"/>
                            <rect x="213" y="194" width="16" height="48" rx="8" fill="#312e81"/>
                            {{-- Decorative --}}
                            <circle cx="340" cy="110" r="28" fill="#818cf8" opacity=".25"/>
                            <circle cx="80"  cy="300" r="20" fill="#4f46e5" opacity=".15"/>
                            <circle cx="360" cy="290" r="16" fill="#fbbf24" opacity=".3"/>
                        </svg>
                    </div>
                    {{-- Floating card — fully clickable --}}
                    <a href="{{ route('jobs.show', 1) }}" class="text-decoration-none">
                        <div class="hero-float-card card border-0 shadow-lg rounded-4 p-3 hover-card">
                            <div class="d-flex align-items-center gap-2 mb-2">
                                <div class="company-logo-sm logo-google rounded-3 d-flex align-items-center justify-content-center text-white fw-bold">G</div>
                                <div>
                                    <div class="fw-semibold small lh-1 text-dark">Frontend Intern</div>
                                    <div class="text-muted" style="font-size:11px">Google · Makati</div>
                                </div>
                                <span class="badge bg-success-soft text-success rounded-pill ms-auto small">Internship</span>
                            </div>
                            <div class="d-flex justify-content-between align-items-center">
                                <span class="text-primary fw-bold small">₱15,000/mo</span>
                                <span class="btn btn-primary btn-sm rounded-pill px-3 py-1" style="font-size:11px">View</span>
                            </div>
                        </div>
                    </a>
                    {{-- Floating badges --}}
                    <div class="hero-badge-1">
                        <i class="fas fa-check-circle text-success me-1"></i>
                        <span class="small fw-semibold">Application Sent!</span>
                    </div>
                    <div class="hero-badge-2">
                        <i class="fas fa-users text-primary me-1"></i>
                        <span class="small fw-semibold">1,200+ Applicants</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- ===== SEARCH BAR ===== --}}
<section class="py-4 bg-white border-bottom">
    <div class="container">
        <form action="{{ route('jobs') }}" method="GET">
            <div class="search-bar-wrap d-flex flex-wrap gap-2 align-items-center p-2 rounded-pill shadow-sm bg-white border">
                <div class="flex-grow-1 d-flex align-items-center gap-2 px-3">
                    <i class="fas fa-search text-primary"></i>
                    <input type="text" name="search" class="form-control border-0 shadow-none p-0" placeholder="Job title, skill, or company...">
                </div>
                <div class="vr d-none d-md-block"></div>
                <div class="d-flex align-items-center gap-2 px-3 d-none d-md-flex">
                    <i class="fas fa-map-marker-alt text-muted"></i>
                    <input type="text" class="form-control border-0 shadow-none p-0" placeholder="Location">
                </div>
                <div class="vr d-none d-md-block"></div>
                <div class="d-flex align-items-center gap-2 px-3 d-none d-md-flex">
                    <i class="fas fa-briefcase text-muted"></i>
                    <select name="type" class="form-select border-0 shadow-none p-0 bg-transparent" style="min-width:120px">
                        <option value="">All Types</option>
                        <option value="internship">Internship</option>
                        <option value="full-time">Full-time</option>
                    </select>
                </div>
                <button type="submit" class="btn btn-primary rounded-pill px-4 py-2 flex-shrink-0">
                    <i class="fas fa-search me-2"></i>Search
                </button>
            </div>
        </form>
        <div class="d-flex flex-wrap gap-2 mt-3 align-items-center">
            <span class="text-muted small">Popular:</span>
            @foreach(['Frontend Developer','UI/UX Designer','Data Analyst','Remote','Internship'] as $tag)
            <a href="{{ route('jobs') }}?search={{ urlencode($tag) }}" class="badge bg-light text-muted rounded-pill px-3 py-2 text-decoration-none hover-tag">{{ $tag }}</a>
            @endforeach
        </div>
    </div>
</section>

{{-- ===== COMPANIES ===== --}}
<section class="py-5 bg-light">
    <div class="container">
        <p class="text-center text-muted small fw-semibold text-uppercase letter-spacing mb-4">Trusted by top companies</p>
        <div class="row g-3 justify-content-center">
            @foreach($companies as $co)
            <div class="col-6 col-md-3 col-lg-auto">
                <a href="{{ route('companies') }}" class="company-chip d-flex align-items-center gap-2 text-decoration-none">
                    <div class="company-logo-sm logo-{{ $co['logo'] }} rounded-3 d-flex align-items-center justify-content-center text-white fw-bold flex-shrink-0">
                        {{ strtoupper(substr($co['name'], 0, 1)) }}
                    </div>
                    <div>
                        <div class="fw-semibold small text-dark">{{ $co['name'] }}</div>
                        <div class="text-muted" style="font-size:11px">{{ $co['jobs'] }} open {{ $co['jobs'] === 1 ? 'role' : 'roles' }}</div>
                    </div>
                </a>
            </div>
            @endforeach
        </div>
    </div>
</section>

{{-- ===== FEATURED INTERNSHIPS ===== --}}
<section class="py-5">
    <div class="container">
        <div class="section-header d-flex justify-content-between align-items-end mb-4">
            <div>
                <span class="section-label">For Students</span>
                <h2 class="fw-bold mb-0">Featured Internships</h2>
            </div>
            <a href="{{ route('internships') }}" class="btn btn-outline-primary rounded-pill px-4 d-none d-md-inline-flex align-items-center gap-2">
                View All <i class="fas fa-arrow-right"></i>
            </a>
        </div>
        <div class="row g-4">
            @foreach($featuredInternships as $job)
            <div class="col-md-6 col-lg-4">
                @include('partials.job-card', ['job' => $job])
            </div>
            @endforeach
        </div>
        <div class="text-center mt-4 d-md-none">
            <a href="{{ route('internships') }}" class="btn btn-outline-primary rounded-pill px-4">View All Internships</a>
        </div>
    </div>
</section>

{{-- ===== FEATURED JOBS ===== --}}
<section class="py-5 bg-light">
    <div class="container">
        <div class="section-header d-flex justify-content-between align-items-end mb-4">
            <div>
                <span class="section-label">Full-time</span>
                <h2 class="fw-bold mb-0">Top Job Openings</h2>
            </div>
            <a href="{{ route('jobs') }}" class="btn btn-outline-primary rounded-pill px-4 d-none d-md-inline-flex align-items-center gap-2">
                View All <i class="fas fa-arrow-right"></i>
            </a>
        </div>
        <div class="row g-4">
            @foreach($featuredJobs as $job)
            <div class="col-md-6 col-lg-4">
                @include('partials.job-card', ['job' => $job])
            </div>
            @endforeach
        </div>
    </div>
</section>

{{-- ===== HOW IT WORKS ===== --}}
<section class="py-5">
    <div class="container">
        <div class="text-center mb-5">
            <span class="section-label">Simple Process</span>
            <h2 class="fw-bold">How CareerHub Works</h2>
        </div>
        <div class="row g-4 text-center">
            @foreach([
                ['step'=>'01','icon'=>'fas fa-user-plus','color'=>'primary','title'=>'Create Account','desc'=>'Sign up for free as a student or employer in under 2 minutes.','link'=>route('register')],
                ['step'=>'02','icon'=>'fas fa-search','color'=>'success','title'=>'Search & Filter','desc'=>'Browse hundreds of internships and jobs filtered by your preferences.','link'=>route('internships')],
                ['step'=>'03','icon'=>'fas fa-paper-plane','color'=>'warning','title'=>'Apply Instantly','desc'=>'One-click apply to multiple positions using your CareerHub profile.','link'=>route('jobs')],
                ['step'=>'04','icon'=>'fas fa-trophy','color'=>'info','title'=>'Get Hired','desc'=>'Receive offers and start your dream career journey today.','link'=>route('register')],
            ] as $step)
            <div class="col-md-3 col-sm-6">
                <a href="{{ $step['link'] }}" class="text-decoration-none">
                    <div class="card border-0 shadow-sm rounded-4 p-4 h-100 hover-card">
                        <div class="step-number text-{{ $step['color'] }}">{{ $step['step'] }}</div>
                        <div class="feature-icon bg-{{ $step['color'] }}-soft text-{{ $step['color'] }} rounded-3 mx-auto mb-3">
                            <i class="{{ $step['icon'] }} fs-4"></i>
                        </div>
                        <h6 class="fw-bold text-dark">{{ $step['title'] }}</h6>
                        <p class="text-muted small mb-0">{{ $step['desc'] }}</p>
                    </div>
                </a>
            </div>
            @endforeach
        </div>
    </div>
</section>

{{-- ===== CTA ===== --}}
<section class="cta-section py-5">
    <div class="container">
        <div class="cta-card rounded-4 p-5 text-center text-white">
            <h2 class="fw-bold mb-3">Ready to Start Your Career Journey?</h2>
            <p class="lead opacity-75 mb-4">Join 10,000+ students who found their dream jobs through CareerHub.</p>
            <div class="d-flex justify-content-center gap-3 flex-wrap">
                <a href="{{ route('register') }}" class="btn btn-white btn-lg rounded-pill px-5 fw-semibold text-primary">
                    <i class="fas fa-user-plus me-2"></i>Create Free Account
                </a>
                <a href="{{ route('internships') }}" class="btn btn-outline-light btn-lg rounded-pill px-4">
                    <i class="fas fa-briefcase me-2"></i>Browse Internships
                </a>
            </div>
        </div>
    </div>
</section>

@endsection
