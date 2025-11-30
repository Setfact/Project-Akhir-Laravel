<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Wisata Bulukumba</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .hero-section { background: linear-gradient(rgba(0,0,0,0.5), rgba(0,0,0,0.5)), url('https://images.unsplash.com/photo-1590523277543-a94d2e4eb00b?w=1200'); background-size: cover; background-position: center; height: 400px; color: white; display: flex; align-items: center; justify-content: center; }
        .card-img-overlay { background: linear-gradient(to top, rgba(0,0,0,0.8), transparent); }
    </style>
</head>
<body>
    
    <nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm sticky-top">
        <div class="container">
            <a class="navbar-brand fw-bold text-primary" href="{{ route('home') }}">Phinisi Point</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item"><a class="nav-link" href="{{ route('home') }}">Beranda</a></li>
                    @auth
                    <li class="nav-item"><a class="nav-link" href="{{ route('my.tickets') }}">Tiket Saya</a></li>
                    @endauth
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">Destinasi</a>
                        <ul class="dropdown-menu">
                            @foreach(\App\Models\Destination::all() as $navDest)
                                <li><a class="dropdown-item" href="{{ route('destination.show', $navDest->slug) }}">{{ $navDest->name }}</a></li>
                            @endforeach
                        </ul>
                    </li>
                </ul>
                <div class="d-flex">
                    @auth
                        <span class="navbar-text me-3">Hi, {{ Auth::user()->name }}</span>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="btn btn-outline-danger btn-sm">Logout</button>
                        </form>
                    @else
                        <a href="{{ route('login') }}" class="btn btn-outline-primary me-2">Login</a>
                        <a href="{{ route('register') }}" class="btn btn-primary">Daftar</a>
                    @endauth
                </div>
            </div>
        </div>
    </nav>

    @yield('content')

    <footer class="bg-dark text-white text-center py-4 mt-5">
        <p>&copy; 2024 Dinas Pariwisata Bulukumba. Tugas Kuliah.</p>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>