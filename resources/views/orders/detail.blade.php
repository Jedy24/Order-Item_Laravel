@extends('layouts.master')

@section('title', 'Order Details')

@section('content')
    <div class="mt-4 p-5 bg-black text-white rounded">
        <h1>Order Detail</h1>
        <a href="{{ route('orders.list') }}" class="btn btn-primary btn-sm">Back to order list</a>
    </div>

    <div class="card border-0 mt-3" style="box-shadow: 0 8px 16px rgba(28, 226, 38, 0.7);">
        <div class="card-body">
            <h5 class="card-title fw-bold">Order Information</h5>
            <p class="card-text"><strong>Order ID :</strong> {{ $order->id }}</p>
            <p class="card-text"><strong>Status :</strong> {{ $order->status }}</p>
        </div>
    </div>

    <div class="container mt-5">
        <div class="card mb-5">
            <div class="card-header bg-success text-white">
                <h5 class="mb-0">Order Details</h5>
            </div>
            <div class="card-body">
                @if(count($details) > 0)
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th scope="col">Nama Item</th>
                                    <th scope="col">Quantity</th>
                                    <th scope="col">Harga</th>
                                    <th scope="col">Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($details as $detail)
                                    <tr>
                                        <td>{{ $detail->nama }}</td>
                                        <td>{{ $detail->quantity }}</td>
                                        <td>Rp. {{ number_format($detail->harga, 2) }}</td>
                                        {{--Perhitungan total harga dengan asumsi pajak 11%--}}
                                        <td>Rp. {{ number_format($detail->quantity * $detail->harga * 1.11, 2) }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="text-center">There's no data.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                @else
                    <p class="card-text text-center">There's no data.</p>
                @endif
            </div>
        </div>
    </div>

@endsection
