@extends('layouts.master')

@section('title', 'Item List')

@section('content')
    <div class="mt-4 p-5 bg-black text-white rounded">
        <h1>Item List</h1>
        <a href="{{ route('items.create') }}" class="btn btn-primary btn-sm">Add New Item</a>
    </div>

    @if (session()->has('success'))
        <div class="alert alert-success mt-4">
            {{ session()->get('success') }}
        </div>
    @endif

    <div class="container mt-5">
        <table class="table table-bordered mb-5">
            <thead>
                <tr class="table-success">
                    <th scope="col">ID</th>
                    <th scope="col">Nama</th>
                    <th scope="col">Harga</th>
                    <th scope="col">Stok</th>
                    <th scope="col">View Item</th>
                    <th scope="col">Action</th>
                </tr>
            </thead>

            <tbody>
                @forelse ($items as $item)
                    <tr>
                        <td>{{ $item->id }}</td>
                        <td>{{ $item->nama }}</td>
                        <td>Rp. {{ number_format($item->harga, 2, ".", ",") }}</td>
                        <td>{{ $item->stok }}</td>
                        <td>
                            <a href="{{ route('items.show', $item->id) }}" type="button" class="btn btn-sm btn-dark">
                                <span class="text-light">View</span>
                            </a>
                        </td>
                        <td>
                            <a href="{{ route('items.edit', $item) }}" class="btn btn-primary btn-sm">
                                Edit
                            </a>
                            <form action="{{ route('items.destroy', $item) }}" method="POST" class="d-inline-block">
                                @method('DELETE')
                                @csrf
                                <button type="submit" class="btn btn-danger btn-sm"
                                    onclick="return confirm('Are you sure?')">Delete
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td align="center" colspan="6">There's no data.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
@endsection
