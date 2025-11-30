<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Destination;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    public function store(Request $request, Destination $destination)
    {
        $request->validate(['quantity' => 'required|integer|min:1']);

        $total = $destination->price * $request->quantity;

        Order::create([
            'user_id' => Auth::id(),
            'destination_id' => $destination->id,
            'quantity' => $request->quantity,
            'total_price' => $total,
            'status' => 'pending',
        ]);

        return redirect()->route('my.tickets')->with('success', 'Pesanan berhasil dibuat!');
    }

    public function index()
    {
        $orders = Order::with('destination')->where('user_id', Auth::id())->latest()->get();
        return view('my_tickets', compact('orders'));
    }
}