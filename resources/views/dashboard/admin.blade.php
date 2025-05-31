@extends('layouts.app')

@section('content')
    <div class="container-fluid dashboard-admin">
        <div class="row">
            <!-- Main Content -->
            <main class="col-md-12 ms-sm-auto col-lg-12 py-1">
                <div class="row g-4">
                    <div class="col-md-3">
                        <div class="card text-bg-primary p-3">
                            <div class="card-body">
                                <p class="card-title mb-0">Keuntungan/Kerugian</p>
                                <p class="card-text mt-0">Rp. {{ number_format($data['keuntungan'], 0, ',', '.') }}
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card text-bg-secondary p-3">
                            <div class="card-body">
                                <p class="card-title mb-0">Total Pemasukan</p>
                                <p class="card-text mt-0">Rp. {{ number_format($data['total_pemasukan'], 0, ',', '.') }}
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card text-bg-secondary p-3">
                            <div class="card-body">
                                <p class="card-title mb-0">Total Pengeluaran</p>
                                <p class="card-text mt-0">Rp. {{ number_format($data['total_pembelian'], 0, ',', '.') }}
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card text-bg-secondary p-3">
                            <div class="card-body">
                                <p class="card-title mb-0">Jumlah Anggota</p>
                                <p class="card-text mt-0">{{ $data['jumlah_member'] }}</p>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Add more content as needed -->
                <div class="row">
                    <div class="col-6">
                        <div class="table-responsive">
                            <p class="mt-5 fs-5 fw-semibold">Data Penjualan</p>
                            <table class="table table-borderless">
                                <thead class="head-table">
                                    <tr>
                                        <th class="text-center">No</th>
                                        <th class="text-center">Barang</th>
                                        <th class="text-center">Jumlah</th>
                                        <th class="text-center">Total Harga</th>
                                        <th class="text-center">Tgl Transaksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($data['penjualan'] as $jual)
                                        <tr class="body-teble">
                                            <td class="text-center">{{ $loop->iteration }}</td>
                                            <td>{{ $jual->inventaris->nama ?? '-' }}</td>
                                            <td class="text-center col-1">{{ $jual->jumlah }}</td>
                                            <td>Rp. {{ number_format($jual->total_harga, 0, '.', '.') }},-</td>
                                            <td class="text-center">
                                                {{ \Carbon\Carbon::parse($jual->tgl_transaksi)->format('d - m - Y') }}
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <div class="col-6">
                        <div class="table-responsive">
                            <p class="mt-5 fs-5 fw-semibold">Data Pengeluaran</p>
                            <table class="table table-borderless">
                                <thead class="head-table">
                                    <tr>
                                        <th class="text-center">No</th>
                                        <th class="text-center">Barang</th>
                                        <th class="text-center">Jumlah</th>
                                        <th class="text-center">Total Harga</th>
                                        <th class="text-center">Tgl Transaksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($data['pengeluaran'] as $jual)
                                        <tr class="body-teble">
                                            <td class="text-center">{{ $loop->iteration }}</td>
                                            <td>{{ $jual->inventaris->nama ?? '-' }}</td>
                                            <td class="text-center col-1">{{ $jual->jumlah }}</td>
                                            <td>Rp. {{ number_format($jual->total_harga, 0, '.', '.') }},-</td>
                                            <td class="text-center">
                                                {{ \Carbon\Carbon::parse($jual->tgl_transaksi)->format('d - m - Y') }}
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </div>
@endsection
@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
@endpush
