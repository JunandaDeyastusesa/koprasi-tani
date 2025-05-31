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
                                <th class="text-center">Nama</th>
                                <th class="text-center">kategori</th>
                                <th class="text-center">Harga Jual</th>
                                <th class="text-center">Jumlah</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($inventaries as $index => $inventaris)
                                <tr class="body-teble">
                                    <td class="text-center">{{ $index + 1 }}</td>
                                    <td>{{ $inventaris->nama }}</td>
                                    <td>{{ $inventaris->kategori }}</td>
                                    <td>Rp. {{ number_format($inventaris->harga_jual, 0, '.', '.') }},-</td>
                                    <td class="text-center col-1">{{ $inventaris->jumlah }}</td>
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
