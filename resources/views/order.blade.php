@extends('layouts.master')

@section('title', 'Create New Order')

<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>

@section('content')
    <div class="mt-4 p-5 bg-black text-white rounded">
        <h1>Add New Order</h1>
    </div>

    @if (session()->has('success'))
        <div class="alert alert-success mt-4">
            {{ session()->get('success') }}
        </div>
    @endif

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

                {{--Dropdown menu untuk memilih status--}}
                <div class="mb-3 col-md-12 col-sm-12">
                    <label for="title" class="form-label font-weight-bold fs-4">Status</label>
                    <select class="form-control" name="status" id="status" value="{{ old('status') }}">
                        <option value="Selesai" selected>Selesai</option>
                        <option value="Menunggu Pembayaran">Menunggu Pembayaran</option>
                    </select>
                </div>

                <div class="col-md-12 mb-3">
                    {{--Menampilkan data item yang jumlah stoknya > 0--}}
                    <div class="mb-3 col-md-12 col-sm-12">
                        <label for="title" class="form-label font-weight-bold fs-4" id="table-item">Item List</label>
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
                                        <td>{{ $item->harga }}</td>
                                        <td>{{ $item->stok }}</td>
                                    </tr>
                                @empty
                                    <td align="center" colspan="6">Empty, there's no item available at the moment.</td>
                                @endforelse
                            </tbody>
                        </table>
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
                                    <tr id="item0">
                                        <td>
                                            <select name="items[]" class="form-control">
                                                <option value="" disabled selected>Select Item</option>
                                                @foreach ($items as $item)
                                                    <option value="{{ $item->id }}">
                                                        {{ $item->nama }} (Rp. {{ number_format($item->harga, 2) }})
                                                    </option>
                                                @endforeach
                                            </select>
                                        </td>

                                        <td>
                                            <input type="number" name="quantities[]" class="form-control" min="1" />
                                        </td>
                                    </tr>

                                    <tr id="item1"></tr>
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

                    {{-- <div class="control-group">
                        <div class="row">
                            <div class="mb-3 col-md-6 col-sm-8">
                                <label for="id">Item</label>
                                <select class="form-control" name="id[]" id="id" value="{{ old('id') }}" onclick="sumTotal()">
                                    <option disabled selected>Select Item</option>
                                    @foreach($items as $item)
                                        <option value="{{ $item->id }}">{{ $item->nama }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="mb-3 col-md-6 col-sm-8">
                                <label for="quantity">Quantity</label>
                                <input type="number" class="form-control" name="quantity[]" id="quantity" value="{{ old('quantity') }}" min="1" oninput="sumTotal()">
                            </div>
                        </div>
                    </div> --}}

                    {{--Class add-more untuk menambah item a.k.a multiple select item--}}
                    {{-- <div class="control-group after-add-more">
                        <div class="d-flex justify-content-center mb-3">
                            <button class="btn btn-dark add-more" type="button">Add more item</button>
                        </div>
                    </div> --}}

                    {{-- <div class="kelas invisible">
                        <div class="control-group">
                            <div class="row">
                                <div class="col-md-6 col-sm-8">
                                    <label for="id">Item</label>
                                    <select class="form-control" name="id[]" id="id" value="{{ old('id') }}" onclick="sumTotal()">
                                        <option disabled selected>Select Item</option>
                                        @foreach($items as $item)
                                            <option value="{{ $item->id }}">{{ $item->nama }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col-md-6 col-sm-8">
                                    <label for="quantity">Quantity</label>
                                    <input type="number" class="form-control" name="quantity[]" id="quantity" value="{{ old('quantity') }}" min="1" oninput="sumTotal()">
                                </div>

                                <div class="col-12 mb-3 mt-3 text-center">
                                    <button class="btn btn-danger btn-block remove" type="button" onclick="sumTotal()">Delete</button>
                                </div>
                            </div>
                        </div>
                    </div> --}}
                </div>

                <div class="mb-3 col-md-12 col-sm-12">
                    <div class="d-flex justify-content-between">
                        <p class="text-muted">Total harga (Inc. PPN)</p>
                        <h5 id="totalHarga"></h5>
                    </div>
                </div>

                <div class="col-12 mb-3 mt-3 text-center">
                    <button class="btn btn-primary" type="submit">Submit Order</button>
                </div>

            </form>
        </div>
    </div>
@endsection

{{--Pop up notif jika stok tidak mencukupi--}}
<div class="modal fade" id="inv-stok" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="stokInfo" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-danger" id="stokInfo">Info</h5>
                <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                Insufficient Stok
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">OK</button>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    //Function untuk multiple select item
    // $(document).ready(function() {
    //     // const modalStok = $('#stok');

    //     $(".add-more").click(function(){
    //         var html = $(".kelas").html();
    //         $(".after-add-more").after(html)
    //     });

    //     $("body").on("click",".remove",function(){
    //         $(this).parents(".control-group").remove();
    //     });
    // });

    //Function untuk menambah item yang dipilih atau multiple select item
    $(document).ready(function(){
        let row_number = 1;
        $("#add_row").click(function(e){
            e.preventDefault();
            let new_row_number = row_number - 1;
            $('#item' + row_number).html($('#item' + new_row_number).html()).find('td:first-child');
            $('#tabel_item').append('<tr id="item' + (row_number + 1) + '"></tr>');
            row_number++;
        });

        //Delete 1 row terakhir
        $("#delete_row").click(function(e){
            e.preventDefault();
            if(row_number > 1){
                $("#item" + (row_number - 1)).html('');
                row_number--;
            }
        });
    });

    //Format angka untuk memisahkan ribuan, misal 123456 -> 123.456
    function format_angka(a){
        return a.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
    }

    // function format_rupiah(a){
    //     return a.toString()replaceAll(',', '.');
    // }

    //Fungsi pembulatan
    const round = (number, decimal) => {
        const rounded = Math.pow(10, decimal);
        return Math.round(number * rounded) / rounded;
    }

    //Menghitung Pajak asumsi pajak adalah 11%
    function ppn(harga) {
        return round(harga * 0.11, 2);
    }

    //Menghitung total harga setelah pajak
    function total(harga, pajak) {
        return round(Number(harga) + Number(pajak), 2);
    }

    function sumTotal() {
        //Mengambil tabel dengan id table-item
        const table = document.getElementById("table-item");
        const rows = table.rows;

        //Mengambil HTML elements nama
        const fieldNama = document.getElementsByClassName('nama');
        const namaCount = fieldNama.length

        //Mengambil HTML elements quantity dan inputnya
        const qty = Array.from(document.getElementsByClassName('quantity'), input => Number(input.value));

        //Inisialisasi total harga
        let totalHarga = 0;

        for (const nama of fieldNama) {
            for (let i = 1; i < rows.length; i++) {
                const row = rows[i];

                //Mengambil kolom tabel dalam bentuk array
                const col = row.getElementsByTagName("TD")[0];

                //Mengambil quantity sesuai dengan nama
                const quantity = qty[fieldNama.indexOf(nama)];

                if (col.innerHTML == nama.value) {
                    if (stokUpdated < 0) {
                    // Debug statement
                    console.log('Negative stock:', stokUpdated);
                    $('#inv-stok').modal('show');
                    console.log(quantity);
                } else {
                    // Debug statement
                    console.log('Adding to totalHarga:', totalHarga);
                    totalHarga += Number(rows.getElementsByTagName("TD")[2].innerHTML) * quantity;
                    // Debug statement
                    console.log('After addition to totalHarga:', totalHarga);
                    }
                }
            }
        }

        // Debug statement
        console.log('Final totalHarga:', totalHarga);

        document.getElementById('totalHarga').innerHTML = format_angka(total(totalHarga, ppn(totalHarga)).toFixed(2));
        // document.getElementById('totalHarga').innerHTML = format_angka(format_rupiah((totalHarga, ppn(totalHarga))).toFixed(2));
    }
</script>


{{-- <div class="row">
    <div class="col-md-12">
        <table class="table">
            <thead>
                <tr>
                    <th>Items</th>
                    <th>Quantity</th>
                </tr>
            </thead>
            <tbody>
                @foreach($items as $item)
                    <tr>
                        <td>
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input" name="id[]" value="{{ $item->id }}" id="item_{{ $item->id }}">
                                <label class="form-check-label" for="item_{{ $item->id }}">{{ $item->nama }}</label>
                            </div>
                        </td>
                        <td>
                            <div class="mb-2">
                                <input type="number" class="form-control" name="quantity[]" id="quantity_{{ $item->id }}" value="{{ old('quantity') }}" min="1" oninput="viewTotal()">
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div> --}}

{{-- @if(session('error'))
    <script>
        $(document).ready(function() {
            $('#no-stok').modal('show');
        });
    </script>
@endif --}}

{{-- for (let j = 0; j < fieldNama.length; j++) {
    for (let i = 1; i < rows.length; i++) {
        let x = rows[i].getElementsByTagName("TD")[0];
        let y = rows[i].getElementsByTagName("TD")[3];

        if (x.innerHTML == fieldNama[j].value) {
            let stok = Number(y.innerHTML) - quantities[j];

            if (stok < 0) {
                modalStok.modal('show');
                console.log(fieldQty[j].value);
            } else {
                let hargaPerItem = Number(rows[i].getElementsByTagName("TD")[2].innerHTML);
                totalHarga += hargaPerItem * quantities[j];
            }
        }
    }

let totalAkhir = total(totalHarga, ppn(totalHarga));
document.getElementById('totalHarga').innerHTML = format_angka(totalAkhir.toFixed(2)); --}}
