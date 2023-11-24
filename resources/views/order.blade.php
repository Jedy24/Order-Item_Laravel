@extends('layouts.master')

@section('title', 'Create New Order')

@section('content')
    <div class="mt-4 p-5 bg-black text-white rounded">
        <h1>Add New Order</h1>
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

    <div class="row my-4">
        <div class="col-12 px-5">
            <form action="{{ route('orders.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="mb-3 col-md-12 col-sm-12">
                    <label for="title" class="form-label font-weight-bold fs-4">Status</label>
                    <select class="form-control" name="status" id="status" value="{{ old('status') }}">
                        <option value="complete" selected>Selesai</option>
                        <option value="pending">Menunggu Pembayaran</option>
                    </select>
                </div>

                <div class="mb-3 col-md-12 col-sm-12">
                    <label for="title" class="form-label font-weight-bold fs-4">Item List</label>
                    <table class="table table-bordered mb-3">
                        <thead>
                            <tr class="table-success">
                                <th scope="col">ID</th>
                                <th scope="col">Nama</th>
                                <th scope="col">Harga</th>
                                <th scope="col">Stok</th>
                            </tr>
                        </thead>

                        <tbody>
                            @forelse ($items as $item)
                                <tr>
                                    <td>{{ $item->id }}</td>
                                    <td>{{ $item->nama }}</td>
                                    <td>Rp. {{ number_format($item->harga, 2, ",", ".") }}</td>
                                    <td>{{ $item->stok }}</td>
                                </tr>
                            @empty
                                <td align="center" colspan="6">Empty, there's no item available at the moment.</td>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="mb-3 col-md-12 col-sm-12">
                    <label for="title" class="form-label font-weight-bold fs-4">Choose Items</label>
                    @foreach ($items as $item)
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="selected_items[]" value="{{ $item->id }}" id="item{{ $item->id }}">
                            <label class="form-check-label" for="item{{ $item->id }}">
                                {{ $item->nama }} - Rp. {{ number_format($item->harga, 2, ",", ".") }}
                            </label>
                            <input class="form-control" type="number" name="items[{{ $item->id }}][quantity]" value="1" min="1">
                        </div>
                    @endforeach
                </div>

                <div class="mb-3 col-md-12 col-sm-12">
                    <label for="title" class="form-label font-weight-bold fs-4">Total Harga (Inc. PPN)</label>
                    <select class="form-control" name="status" id="status" value="{{ old('status') }}">
                        <option value="complete" selected>Selesai</option>
                        <option value="pending">Menunggu Pembayaran</option>
                    </select>
                </div>
            </form>
        </div>
    </div>

    {{-- <form action="{{ route('orders.store') }}" method="post">
        @csrf
        <label for="status">Order Status:</label>
        <select name="status" id="status">
            <option value="Selesai">Selesai</option>
            <option value="Menunggu Pembayaran">Menunggu Pembayaran</option>
        </select>

        <label for="items">Choose Items:</label>
        @foreach ($items as $item)
            <div>
                <input type="checkbox" name="items[{{ $item->id }}][item_id]" value="{{ $item->id }}">
                <label>{{ $item->nama }} - Rp. {{ number_format($item->harga, 2) }}</label>
                <input type="number" name="items[{{ $item->id }}][quantity]" value="1" min="1">
            </div>
        @endforeach

        <button type="submit">Submit Order</button>
    </form> --}}
@endsection
