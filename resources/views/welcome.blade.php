@extends('layouts.main')

@section('content')
<div class="hero-section text-center">
    <div>
        <h1 class="display-4 fw-bold">Jelajahi Bulukumba</h1>
        <p class="lead">Temukan surga tersembunyi di Sulawesi Selatan</p>
    </div>
</div>

<div class="container my-5">
    <h3 class="text-center mb-4 text-primary">Destinasi Populer</h3>
    <div class="row">
        @foreach($destinations as $dest)
        <div class="col-12 col-md-4 mb-4">
            <a href="{{ route('destination.show', $dest->slug) }}" class="text-white text-decoration-none">
                <div class="card border-0 shadow h-100 text-white overflow-hidden">
                    <img src="{{ $dest->image_url }}" class="card-img h-100" alt="{{ $dest->name }}" style="object-fit: cover; min-height: 250px;">
                    <div class="card-img-overlay d-flex align-items-end">
                        <div class="w-100">
                            <h5 class="card-title fw-bold mb-0">{{ $dest->name }}</h5>
                            <small>Mulai Rp {{ number_format($dest->price, 0, ',', '.') }}</small>
                        </div>
                    </div>
                </div>
            </a>
        </div>
        @endforeach
    </div>
</div>
@endsection