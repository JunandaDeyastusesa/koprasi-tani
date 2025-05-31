<!-- Modal Edit Transaksi -->
<div class="modal fade show" id="editModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
    aria-labelledby="editModalLabel" aria-modal="true" style="display: block;">
    <div class="modal-dialog modal-lg">
        <div class="modal-content p-2">
            <div class="modal-header mb-2 pb-3">
                <h1 class="modal-title fs-5" id="editModalLabel">Edit Transaksi</h1>
                <a href="{{ route('transaksi.index') }}" class="btn-close" aria-label="Tutup"></a>
            </div>
            <div class="modal-body">
                <form action="{{ route('transaksi.update', $transaksi->id) }}" method="POST" id="formtransaksi">
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="id" id="edit_transaksi_id" value="{{ $transaksi->id }}">

                    <div class="row">
                        <!-- Status -->
                        <div class="mb-3 col-md-6" style="display: none;">
                            <label for="edit_status" class="form-label">Pilih Status</label>
                            <select name="status" id="edit_status" readonly
                                class="form-select @error('status') is-invalid @enderror" required>
                                <option value="" disabled
                                    {{ old('status', $transaksi->status) == '' ? 'selected' : '' }}>Pilih Status
                                </option>
                                <option value="Penjualan"
                                    {{ old('status', $transaksi->status) == 'Penjualan' ? 'selected' : '' }}>Penjualan
                                </option>
                                <option value="Pembelian"
                                    {{ old('status', $transaksi->status) == 'Pembelian' ? 'selected' : '' }}>Pembelian
                                </option>
                            </select>
                            @error('status')
                                <span class="text-danger small">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="mb-3 col-md-6">
                            <label for="status" class="form-label">Status</label>
                            <input type="text" min="1" name="status" id="status"
                                value="{{ old('status', $transaksi->status) }}"
                                class="form-control @error('status') is-invalid @enderror" placeholder="Masukkan status"
                                required readonly>
                            @error('status')
                                <span class="text-danger small">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Member -->
                        <div class="mb-3 col-md-6" id="edit-dropdown-member" style="display: none;">
                            <label for="edit_user_id" class="form-label">Member</label>
                            <select name="user_id" id="edit_user_id"
                                class="form-select @error('user_id') is-invalid @enderror">
                                <option value="" disabled>Pilih Member</option>
                                @foreach ($user as $users)
                                    <option value="{{ $users->id }}"
                                        {{ old('user_id', $transaksi->user_id) == $users->id ? 'selected' : '' }}>
                                        {{ $users->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('user_id')
                                <span class="text-danger small">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Mitra -->
                        <div class="mb-3 col-md-6" id="edit-dropdown-mitra" style="display: none;">
                            <label for="edit_mitra_id" class="form-label">Mitra</label>
                            <select name="mitra_id" id="edit_mitra_id"
                                class="form-select @error('mitra_id') is-invalid @enderror">
                                <option value="" disabled>Pilih Mitra</option>
                                @foreach ($mitras as $mitra)
                                    <option value="{{ $mitra->id }}"
                                        {{ old('mitra_id', $transaksi->mitra_id) == $mitra->id ? 'selected' : '' }}>
                                        {{ $mitra->nama }}
                                    </option>
                                @endforeach
                            </select>
                            @error('mitra_id')
                                <span class="text-danger small">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Inventaris -->
                        <div class="mb-3 col-md-6">
                            <label for="edit_inventari_id" class="form-label">Inventaris</label>
                            <select name="inventari_id" id="edit_inventari_id"
                                class="form-select @error('inventari_id') is-invalid @enderror" required>
                                <option value="" disabled>Pilih Inventaris</option>
                                @foreach ($inventaris as $item)
                                    <option value="{{ $item->id }}"
                                        {{ old('inventari_id', $transaksi->inventari_id) == $item->id ? 'selected' : '' }}>
                                        {{ $item->nama }}
                                    </option>
                                @endforeach
                            </select>
                            @error('inventari_id')
                                <span class="text-danger small">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Jumlah -->
                        <div class="mb-3 col-md-6">
                            <label for="edit_jumlah" class="form-label">Jumlah</label>
                            <input type="number" min="1" name="jumlah" id="edit_jumlah"
                                value="{{ old('jumlah', $transaksi->jumlah) }}"
                                class="form-control @error('jumlah') is-invalid @enderror" placeholder="Masukkan jumlah"
                                required>
                            @error('jumlah')
                                <span class="text-danger small">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Total Harga -->
                        <div class="mb-3 col-md-6">
                            <label for="edit_total_harga" class="form-label">Total Harga</label>
                            <input type="number" name="total_harga" id="edit_total_harga"
                                value="{{ old('total_harga', $transaksi->total_harga) }}" class="form-control"
                                placeholder="Total Harga">
                            @error('total_harga')
                                <span class="text-danger small">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Tanggal Transaksi -->
                        <div class="mb-3 col-md-6">
                            <label for="edit_tgl_transaksi" class="form-label">Tanggal Transaksi</label>
                            <input type="date" name="tgl_transaksi" id="edit_tgl_transaksi"
                                value="{{ old('tgl_transaksi', isset($transaksi->tgl_transaksi) ? date('Y-m-d', strtotime($transaksi->tgl_transaksi)) : '') }}"
                                class="form-control @error('tgl_transaksi') is-invalid @enderror" required>
                            @error('tgl_transaksi')
                                <span class="text-danger small">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <!-- Tombol -->
                    <div class="modal-footer border-0 d-flex justify-content-between p-0 mt-3">
                        <a href="{{ route('transaksi.index') }}" class="btn btn-outline-secondary px-4">Batal</a>
                        <button type="submit" class="btn btn-primary px-4">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<style>
    /* Class untuk sembunyikan elemen */
    .d-none {
        display: none !important;
    }
</style>

<script>
    // Inisialisasi data inventaris
    const inventarisData = @json($inventaris);

    // Fungsi untuk menampilkan/menyembunyikan dropdown
    function toggleDropdowns() {
        const status = document.getElementById('edit_status').value;
        const memberDiv = document.getElementById('edit-dropdown-member');
        const mitraDiv = document.getElementById('edit-dropdown-mitra');

        // Reset semua dropdown
        memberDiv.style.display = 'none';
        mitraDiv.style.display = 'none';

        // Tampilkan sesuai status
        if (status === 'Penjualan') {
            memberDiv.style.display = 'block';
        } else if (status === 'Pembelian') {
            mitraDiv.style.display = 'block';
        }
    }

    // Alternatif jika modal di-load via AJAX
    if (document.getElementById('editModal')) {
        document.getElementById('editModal').addEventListener('shown.bs.modal', function() {
            toggleDropdowns();
            updateTotalHarga();
        });
    }
</script>
