@extends('layouts.master')

@section('title', 'Add New Item')

@section('content')
    <div class="mt-4 p-5 bg-black text-white rounded">
        <h1>Add New Item</h1>
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

    <div class="row my-5">
        <div class="col-12 px-5">
            <form action="{{ route('items.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="mb-3 col-md-12 col-sm-12">
                    <label for="title" class="form-label">ID</label>
                    <input type="text" class="form-control" name="id" id="id" value="{{ $var_id }}" readonly>
                </div>

                <div class="mb-3 col-md-12 col-sm-12">
                    <label for="title" class="form-label">Nama</label>
                    <input type="text" class="form-control" name="nama" id="nama" value="{{ old('nama') }}">
                </div>

                <div class="mb-3 col-md-12 col-sm-12">
                    <label for="title" class="form-label">Harga</label>
                    <input type="number" class="form-control" name="harga" id="harga" min="0" value="{{ old('harga') }}">
                </div>

                <div class="mb-3 col-md-12 col-sm-12">
                    <label for="title" class="form-label">Stok</label>
                    <input type="number" class="form-control" name="stok" id="stok" min="0" value="{{ old('stok') }}">
                </div>

                <button type="submit" class="btn btn-primary btn-block mt-3">Save</button>
            </form>
        </div>
    </div>
@endsection
