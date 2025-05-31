@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <main class="col-md-12 ms-sm-auto col-lg-12 py-1">

                <div class="table-responsive">
                    <table class="table table-borderless" id="memberTable">
                        <thead class="head-table">
                            <tr>
                                <th class="text-center">ID</th>
                                <th class="text-center">Barang</th>
                                <th class="text-center">Jumlah</th>
                                <th class="text-center">Total Harga</th>
                                <th class="text-center">Tgl Transaksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($transaksis as $index => $transaksi)
                                <tr class="body-teble">
                                    <td class="text-center">{{ $index + 1 }}</td>
                                    <td>{{ $transaksi->inventaris->nama ?? '-' }}</td>
                                    <td class="text-center col-1">{{ $transaksi->jumlah }}</td>
                                    <td>Rp. {{ number_format($transaksi->total_harga, 0, '.', '.') }},-</td>
                                    <td class="text-center">{{ \Carbon\Carbon::parse($transaksi->tgl_transaksi)->format('d - m - Y') }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </main>
        </div>
    </div>
@endsection
@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#memberTable').DataTable();

        });
    </script>
@endpush
