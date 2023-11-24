@extends('layouts.master')

@section('title', 'Show Item Detail')

@section('content')
    <div class="mt-4 p-5 bg-black text-white rounded">
        <h1>Item Details</h1>
    </div>

    @if ($errors->any())
        <div class="alert alert-danger mt-4">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="container mt-5">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Item Information</h5>
                <ul class="list-group list-group-flush">
                    <li class="list-group-item"><strong>ID:</strong> {{ $item->id }}</li>
                    <li class="list-group-item"><strong>Nama:</strong> {{ $item->nama }}</li>
                    <li class="list-group-item"><strong>Harga:</strong> Rp. {{ number_format($item->harga, 2, ".", ",") }}</li>
                    <li class="list-group-item"><strong>Stok:</strong> {{ $item->stok }}</li>
                </ul>
            </div>
        </div>
    </div>

    <div class="text-center mt-3">
        <a href="{{ route('items.index') }}" class="btn btn-primary btn-sm">Back to Item List</a>
    </div>
@endsection
