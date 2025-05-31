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
                                <th class="text-center">Nama Mitra</th>
                                <th class="text-center">Email</th>
                                <th class="text-center">No Telp</th>
                                <th class="text-center">Alamat</th>
                                <th class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($mitras as $index => $mitra)
                                <tr class="body-teble">
                                    <td class="text-center">{{ $index + 1 }}</td>
                                    <td>{{ $mitra->nama }}</td>
                                    <td>{{ $mitra->email }}</td>
                                    <td>{{ $mitra->no_hp }}</td>
                                    <td>{{ $mitra->alamat }}</td>
                                    <td class="text-center px-1 d-flex justify-content-center">
                                        <a href="#" class="btn btn-sm btn-edit me-2" data-id="{{ $mitra->id }}">
                                            <i class=" bi bi-pencil-square text-white"></i>
                                        </a>
                                        <div>
                                            <form action="{{ route('mitras.destroy', ['mitra' => $mitra->id]) }}"
                                                method="POST" class="delete-form">
                                                @csrf
                                                @method('DELETE')
                                                <button type="button" class="btn btn-outline-dark btn-sm me-2 btn-hapus"
                                                    data-id="{{ $mitra->id }}">
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

                $.get('/mitras/create', function(data) {
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
                $.get("/mitras/" + id + "/edit", function(data) {
                    $("#editModalContainer").html(data);
                    setTimeout(() => {
                        let modalElement = document.getElementById("editModal");
                        if (modalElement) {
                            let myModal = new bootstrap.Modal(modalElement);
                            myModal.show();
                        }
                    });
                }).fail(function(xhr) {
                    alert("Gagal mengambil data member!");
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
