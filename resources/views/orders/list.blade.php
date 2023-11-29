@extends('layouts.master')

@section('title', 'Order List')

@section('content')
    <div class="mt-4 p-5 bg-black text-white rounded">
        <h1>Order List</h1>
        <a href="{{ route('orders.create') }}" class="btn btn-primary btn-sm">Create New Order</a>
    </div>

    <div class="container mt-5">
        <table class="table table-bordered mb-5">
            <thead>
                <tr class="table-success">
                    <th scope="col" class="col-2">ID</th>
                    <th scope="col" class="col-6">Status</th>
                    <th scope="col" class="col-4">Action</th>
                </tr>
            </thead>

            <tbody>
                @forelse ($orders as $order)
                    <tr>
                        <td>{{ $order->id }}</td>
                        <td>{{ $order->status }}</td>
                        <td>
                            <a href="{{ route('orders.detail', $order) }}" type="button" class="btn btn-sm btn-primary">
                                <span class="text-light">View Details</span>
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td align="center" colspan="6">There's no data.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        <div class="d-flex justify-content-center">
            {!! $orders->links() !!}
        </div>
    </div>
@endsection
