@extends('layouts.main')

@section('content')
<div class="container my-5">
    <h3 class="mb-4">Tiket Saya</h3>
    
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="card border-0 shadow-sm">
        <div class="card-body">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>Wisata</th>
                        <th>Jumlah</th>
                        <th>Total Harga</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($orders as $order)
                    <tr>
                        <td>{{ $order->destination->name }}</td>
                        <td>{{ $order->quantity }} org</td>
                        <td>Rp {{ number_format($order->total_price, 0, ',', '.') }}</td>
                        <td>
                            @if($order->status == 'pending')
                                <span class="badge bg-warning">Menunggu Pembayaran</span>
                            @elseif($order->status == 'paid')
                                <span class="badge bg-success">Lunas</span>
                            @else
                                <span class="badge bg-danger">Batal</span>
                            @endif
                        </td>
                        <td>
                            @if($order->status == 'pending')
                                <button class="btn btn-sm btn-outline-primary" onclick="alert('Silahkan transfer ke Bank BRI: 1234-5678-90 a.n Dinas Pariwisata. Lalu kirim bukti ke WA Admin.')">Bayar</button>
                            @else
                                <button class="btn btn-sm btn-secondary" disabled>Selesai</button>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection