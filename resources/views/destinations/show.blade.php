@extends('layouts.main')

@section('content')
<div class="container my-5">
    <div class="row">
        <div class="col-md-8">
            <img src="{{ $destination->image_url }}" class="img-fluid rounded shadow mb-4 w-100" alt="{{ $destination->name }}">
            <h2 class="fw-bold">{{ $destination->name }}</h2>
            <p class="text-muted"><i class="bi bi-geo-alt"></i> {{ $destination->location }}</p>
            <hr>
            <p class="lead">{{ $destination->description }}</p>
        </div>

        <div class="col-md-4">
            <div class="card shadow border-0 sticky-top" style="top: 100px;">
                <div class="card-body">
                    <h4 class="fw-bold text-primary">Rp {{ number_format($destination->price, 0, ',', '.') }}</h4>
                    <span class="text-muted">per orang</span>
                    
                    <form action="{{ route('order.store', $destination->id) }}" method="POST" class="mt-4">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label">Jumlah Tiket</label>
                            <input type="number" name="quantity" class="form-control" value="1" min="1" required>
                        </div>
                        
                        @auth
                            <button type="submit" class="btn btn-primary w-100 btn-lg">Pesan Sekarang</button>
                        @else
                            <a href="{{ route('login') }}" class="btn btn-outline-primary w-100">Login untuk Pesan</a>
                        @endauth
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection