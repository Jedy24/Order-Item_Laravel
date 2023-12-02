@extends('layouts.master')

@section('title', 'Create New Order')

<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>

@section('content')
    <div class="mt-4 p-5 bg-black text-white rounded">
        <h1>Add New Order</h1>
    </div>

    @if (session()->has('error'))
        <div class="alert alert-danger mt-4">
            {{ session()->get('error') }}
        </div>
    @endif

    <div class="row my-4">
        <div class="col-12 px-5">
            <form action="{{ route('orders.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                {{--Dropdown menu untuk memilih status--}}
                <div class="mb-3 col-md-12 col-sm-12">
                    <label for="title" class="form-label font-weight-bold fs-4">Status</label>
                    <select class="form-control" name="status" id="status" value="{{ old('status') }}">
                        <option value="Selesai" selected>Selesai</option>
                        <option value="Menunggu Pembayaran">Menunggu Pembayaran</option>
                    </select>
                </div>

                {{--Menampilkan data item yang jumlah stoknya > 0--}}
                <div class="col-md-12 mb-3">
                    <div class="mb-3 col-md-12 col-sm-12">
                        <label for="title" class="form-label font-weight-bold fs-4" id="tabel_data">Item List</label>
                        <table class="table table-bordered mb-3" id="tabel_data">
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
                                        <td>Rp. {{ number_format($item->harga, 2) }}</td>
                                        <td>{{ $item->stok }}</td>
                                    </tr>
                                @empty
                                    <td align="center" colspan="6">Empty, there's no item available at the moment.</td>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

                {{--Label--}}
                <div class="container text-center mt-4">
                    <div class="mb-3 col-md-12 col-sm-12 mx-auto">
                        <label for="title" class="form-label font-weight-bold fs-4">Choose Items</label>
                    </div>
                </div>

                <div class="col-md-12 mb-3">
                    <div class="card-body">
                        <table class="table" id="tabel_item">
                            <thead>
                                <th>Item</th>
                                <th>Quantity</th>
                            </thead>

                            <tbody>
                                <tr>
                                    <td>
                                        <select name="items[]" class="form-control">
                                            <option value="" disabled selected>Select Item</option>
                                            @foreach ($items as $item)
                                                <option value="{{ $item->id }}" data-harga="{{ $item->harga }}" data-stok="{{ $item->stok }}">
                                                    {{ $item->nama }} (Rp. {{ number_format($item->harga, 2) }})
                                                </option>
                                            @endforeach
                                        </select>
                                    </td>

                                    <td>
                                        <input type="number" name="quantities[]" class="form-control" min="1" />
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <button id="add_row" class="btn btn-dark">Add New Item</button>
                    </div>
                    <div class="col-6 text-right">
                        <button id='delete_row' class="btn btn-danger">Delete Item</button>
                    </div>
                </div>
        </div>

                <div class="mb-3 col-md-12 col-sm-12">
                    <div class="d-flex justify-content-between">
                        <p class="text-muted mx-5">Total harga (Inc. PPN) :</p>
                        <h5 id="totalHarga" class="mx-5"></h5>
                    </div>
                </div>

                <div class="col-12 mb-3 mt-3 text-center">
                    <button class="btn btn-primary" type="submit" id="submit_order">Submit Order</button>
                </div>
            </form>
        </div>
    </div>
@endsection

<script type="text/javascript">
    /**Function untuk menambah item yang dipilih atau multiple select item*/
    $(document).ready(function () {
        let row_number = 1;
        let disabledOptions = {};

        /**Function Menambah baris*/
        $("#add_row").click(function (e) {
            e.preventDefault();

            /**Duplicate baris sebelumnya*/
            let new_row = $("#tabel_item tbody tr:first").clone();

            /**Reset value item dan quantity*/
            new_row.find('select[name="items[]"]').val('');
            new_row.find('input[name="quantities[]"]').val('');

            /**Menambah baris baru*/
            $('#tabel_item tbody').append(new_row);

            row_number++;

            /**disableOptions();*/
        });

        /**Function delete baris*/
        $("#delete_row").click(function (e) {
            e.preventDefault();
            if (row_number > 1) {

                /**Menghapus baris item terakhir*/
                $("#tabel_item tbody tr:last").remove();
                row_number--;

                /**Kalkulasi total harga keseluruhan*/
                calculateTotal();

                /**disableOptions();*/
            }
        });

        function calculateTotal() {
            let totalHarga = 0;

            /**Looping per baris pada tabel dengan id = tabel_item*/
            $('#tabel_item tbody tr').each(function () {
                const quantity = parseFloat($(this).find("input[name='quantities[]']").val()) || 0;
                const harga = parseFloat($(this).find("select[name='items[]']").find(':selected').data('harga')) || 0;

                /**Menghitung total harga per item dengan asumsi pajak 11%*/
                const totalPerItem = harga * quantity * 1.11;

                /**Kalkulasi total harga keseluruhan*/
                totalHarga += totalPerItem;
            });

            /**Menampilkan total harga keseluruhan*/
            $("#totalHarga").text("Rp. " + totalHarga.toFixed(2).replace(/\d(?=(\d{3})+\.)/g, '$&,'));
        }

        /**Function EventListener untuk input pada tabel_item*/
        $('#tabel_item').on('input', 'input[name="quantities[]"], select[name="items[]"]', calculateTotal);

        /**Function disableOptions berfungsi untuk disable item yang telah dipilih sebelumnya.
         * Function tersebut bertujuan agar tidak terjadi duplikasi ID item saat menyimpan data order.
         * Terjadi conflict dengan perubahan stok saat order, item yang disabled menjadi tidak bisa berkurang stoknya.
         * disbleOptions sendiri terjadi error dimana hanya bisa disable item terakhir yang dipilih.
        */

        /**Function untuk disable item yang telah dipilih sebelumnya*/
        // function disableOptions() {
        //     /**Mengambil data item yang telah dipilih*/
        //     let selectedItems = [];

        //     $('#tabel_item select[name="items[]"]').each(function () {
        //         let selectedValue = $(this).val();
        //         if (selectedValue) {
        //             selectedItems.push(selectedValue);
        //         }
        //     });

        //     /**Disable item yang telah dipilih*/
        //     $('#tabel_item select[name="items[]"]').each(function () {
        //         let currentDropdown = $(this);

        //         currentDropdown.find('option').prop('disabled', false);

        //         selectedItems.forEach(function (value) {
        //             currentDropdown.find('option[value="' + value + '"]').prop('disabled', true);
        //         });
        //     });
        // }
    });
</script>
