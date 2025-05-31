@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <main class="col-md-12 ms-sm-auto col-lg-12 py-1">
                <div class="d-flex justify-content-end mb-3">
                    <a href="#" class="btn btn-primary btn-create">Tambah</a>
                </div>

                <div class="table-responsive">
                    <table class="table table-borderless" id="memberTable">
                        <thead class="head-table">
                            <tr>
                                <th class="text-center">ID</th>
                                <th class="text-center">Nama</th>
                                <th class="text-center">Barang</th>
                                <th class="text-center">Jumlah</th>
                                <th class="text-center">Total Harga</th>
                                <th class="text-center">Status</th>
                                <th class="text-center">Tgl Transaksi</th>
                                <th class="text-center col-1">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($transaksis as $index => $transaksi)
                                <tr class="body-teble">
                                    <td class="text-center">{{ $index + 1 }}</td>
                                    <td>{{ $transaksi->mitra->nama ?? $transaksi->user->name ?? '-' }}</td>
                                    <td>{{ $transaksi->inventaris->nama ?? '-' }}</td>
                                    <td class="text-center col-1">{{ $transaksi->jumlah }}</td>
                                    <td>Rp. {{ number_format($transaksi->total_harga, 0, '.', '.') }},-</td>
                                    <td class="text-center">{{ $transaksi->status }}</td>
                                    <td class="text-center">{{ \Carbon\Carbon::parse($transaksi->tgl_transaksi)->format('d - m - Y') }}</td>

                                    <td class="text-center px-1 d-flex justify-content-center">
                                        <a href="#" class="btn btn-sm btn-detail me-2"
                                            data-id="{{ $transaksi->id }}">
                                            <i class=" bi bi-eye text-white"></i>
                                        </a>
                                        <a href="#" class="btn btn-sm btn-edit me-2" data-id="{{ $transaksi->id }}">
                                            <i class=" bi bi-pencil-square text-white"></i>
                                        </a>
                                        <div>
                                            <form action="{{ route('transaksi.destroy', ['transaksi' => $transaksi->id]) }}"
                                                method="POST" class="delete-form">
                                                @csrf
                                                @method('DELETE')
                                                <button type="button" class="btn btn-outline-dark btn-sm me-2 btn-hapus"
                                                    data-id="{{ $transaksi->id }}">
                                                    <i class="bi bi-trash-fill text-white"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </main>
        </div>
    </div>
    <div id="addModalContainer"></div>
    <div id="editModalContainer"></div>
    <div id="showModalContainer"></div>
@endsection
@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#memberTable').DataTable();

        });
    </script>

    <script>
        $(document).ready(function() {
            $('.btn-create').on('click', function(e) {
                e.preventDefault();

                $.get('/transaksi/create', function(data) {
                    $('#addModalContainer').html(data);

                    setTimeout(() => {
                        let modalElement = document.getElementById('addModal');
                        if (modalElement) {
                            let myModal = new bootstrap.Modal(modalElement);
                            myModal.show();
                        } else {
                            console.error('Modal tidak ditemukan.');
                        }
                    });
                }).fail(function() {
                    alert('Gagal memuat modal. Coba lagi.');
                });
            });
        });
    </script>
    <script>
        $(document).ready(function() {
            $(".btn-edit").on("click", function(e) {
                e.preventDefault();
                let id = $(this).data("id");
                $.get("/transaksi/" + id + "/edit", function(data) {
                    $("#editModalContainer").html(data);
                    setTimeout(() => {
                        let modalElement = document.getElementById("editModal");
                        if (modalElement) {
                            let myModal = new bootstrap.Modal(modalElement);
                            myModal.show();
                        }
                    });
                }).fail(function(xhr) {
                    alert("Gagal mengambil data Transaksi!");
                });
            });
        });
    </script>
    <script>
        $(document).ready(function() {
            $('.btn-detail').on('click', function(e) {
                e.preventDefault();
                let id = $(this).data('id');
                $.get('/transaksi/' + id, function(data) {
                    $('#showModalContainer').html(data);
                    setTimeout(() => {
                        let modalElement = document.getElementById('showModal');
                        if (modalElement) {
                            let myModal = new bootstrap.Modal(modalElement);
                            myModal.show();
                        }
                    });
                });
            });
        });
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const hapusButtons = document.querySelectorAll('.btn-hapus');

            hapusButtons.forEach(button => {
                button.addEventListener('click', function() {
                    const form = this.closest('form');

                    Swal.fire({
                        title: 'Apakah kamu yakin?',
                        text: "Data akan dihapus permanen!",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#d33',
                        cancelButtonColor: '#3085d6',
                        confirmButtonText: 'Ya, hapus!',
                        cancelButtonText: 'Batal'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            form.submit();
                        }
                    });
                });
            });
        });
    </script>
@endpush
