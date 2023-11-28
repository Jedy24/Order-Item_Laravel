@extends('layouts.master')

@section('title', 'Welcome Page')

@section('content')
    <div class="mt-4 p-5 bg-black text-white rounded">
        <h1>Order Details</h1>
    </div>

    <div class="d-flex justify-content-center mt-3">
        <div class="card border-0 mx-3" style="width: 33rem; box-shadow: 0 8px 16px rgba(82, 149, 236, 0.7);">
            <div class="card-body">
                <p class="card-title fw-bold display-6">Item count</p>
                <h3 class="card-text">{{ $countItem }}</h3>
                <a href="{{ route('items.index') }}" class="btn btn-primary mt-3">View All Items</a>
            </div>
        </div>

        <div class="card border-0 mx-3" style="width: 33rem; box-shadow: 0 8px 16px rgba(82, 149, 236, 0.7);">
            <div class="card-body">
                <p class="card-title fw-bold display-6">Order count</p>
                <h3 class="card-text">{{ $countOrder }}</h3>
                <a href="{{ route('orders.index') }}" class="btn btn-primary mt-3">View All Orders</a>
            </div>
        </div>
    </div>

@endsection

