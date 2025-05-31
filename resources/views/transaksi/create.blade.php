<!-- Modal Tambah Transaksi -->
<div class="modal fade" id="addModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
    aria-labelledby="addModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content p-2">
            <div class="modal-header mb-2 pb-3">
                <h1 class="modal-title fs-5" id="addModalLabel">Tambah Transaksi</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('transaksi.store') }}" method="POST">
                    @csrf
                    <div class="row">

                        <!-- STATUS (Letakkan ini sebelum Member/Mitra) -->
                        <div class="mb-3 col-md-6">
                            <div class="form-group">
                                <label for="status" class="pb-2">Pilih Status</label>
                                <select name="status" id="status"
                                    class="form-select @error('status') is-invalid @enderror" required>
                                    <option value="" disabled selected>Pilih Status</option>
                                    <option value="Penjualan">Penjualan</option>
                                    <option value="Pembelian">Pembelian</option>
                                </select>
                                @error('status')
                                    <span class="text-danger small">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <!-- Dropdown Member -->
                        <div class="mb-3 col-md-6" id="dropdown-member" style="display: none;">
                            <label for="mitra_id_member" class="form-label">Member</label>
                            <select name="user_id" id="mitra_id_member"
                                class="form-select @error('user_id') is-invalid @enderror">
                                <option value="" disabled selected>Pilih Member</option>
                                @foreach ($user as $users)
                                    <option value="{{ $users->id }}"
                                        {{ old('user_id') == $users->id ? 'selected' : '' }}>
                                        {{ $users->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('user_id')
                                <span class="text-danger small">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Dropdown Mitra -->
                        <div class="mb-3 col-md-6" id="dropdown-mitra" style="display: none;">
                            <label for="mitra_id_mitra" class="form-label">Mitra</label>
                            <select name="mitra_id" id="mitra_id_mitra"
                                class="form-select @error('mitra_id') is-invalid @enderror">
                                <option value="" disabled selected>Pilih Mitra</option>
                                @foreach ($mitras as $mitra)
                                    <option value="{{ $mitra->id }}"
                                        {{ old('mitra_id') == $mitra->id ? 'selected' : '' }}>
                                        {{ $mitra->nama }}
                                    </option>
                                @endforeach
                            </select>
                            @error('mitra_id')
                                <span class="text-danger small">{{ $message }}</span>
                            @enderror
                        </div>


                        <div class="mb-3 col-md-6">
                            <label for="inventari_id" class="form-label">Inventaris</label>
                            <select name="inventari_id" id="inventari_id"
                                class="form-select @error('inventari_id') is-invalid @enderror" required>
                                <option value="" disabled selected>Pilih Inventaris</option>
                                @foreach ($inventaris as $item)
                                    <option value="{{ $item->id }}"
                                        {{ old('inventari_id') == $item->id ? 'selected' : '' }}>
                                        {{ $item->nama }}
                                    </option>
                                @endforeach
                            </select>
                            @error('inventari_id')
                                <span class="text-danger small">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="mb-3 col-md-6">
                            <label for="jumlah" class="form-label">Jumlah</label>
                            <input type="number" min="1" name="jumlah" id="jumlah"
                                class="form-control @error('jumlah') is-invalid @enderror" value="{{ old('jumlah') }}"
                                placeholder="Masukkan jumlah" required>
                            @error('jumlah')
                                <span class="text-danger small">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="mb-3 col-md-6">
                            <label for="total_harga" class="form-label">Total Harga</label>
                            <input type="number" name="total_harga" id="total_harga" readonly class="form-control"
                                placeholder="Total Harga">
                            @error('total_harga')
                                <span class="text-danger small">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="mb-3 col-md-6">
                            <label for="tgl_transaksi" class="form-label">Tanggal Transaksi</label>
                            <input type="date" name="tgl_transaksi" id="tgl_transaksi"
                                class="form-control @error('tgl_transaksi') is-invalid @enderror"
                                value="{{ old('tgl_transaksi') }}" required>
                            @error('tgl_transaksi')
                                <span class="text-danger small">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <div class="modal-footer border-0 d-flex justify-content-between p-0 mt-3">
                        <button type="button" class="btn btn-outline-secondary px-4"
                            data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary px-4">Tambah</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
    function setupTransactionTypeToggle() {
        const statusSelect = document.getElementById('status');
        const dropdownMember = document.getElementById('dropdown-member');
        const dropdownMitra = document.getElementById('dropdown-mitra');
        const totalHarga = document.getElementById('total_harga');

        function toggleDropdowns() {
            const selectedValue = statusSelect.value;

            // Sembunyikan semua dropdown terlebih dahulu
            dropdownMember.style.display = 'none';
            dropdownMitra.style.display = 'none';

            // Tampilkan dropdown dan atur readonly sesuai pilihan
            if (selectedValue === 'Penjualan') {
                dropdownMember.style.display = 'block';
                totalHarga.readOnly = true;
            } else if (selectedValue === 'Pembelian') {
                dropdownMitra.style.display = 'block';
                totalHarga.readOnly = false;
            } else {
                totalHarga.readOnly = false;
            }
        }

        toggleDropdowns();

        statusSelect.addEventListener('change', toggleDropdowns);
    }

    document.getElementById('addModal').addEventListener('shown.bs.modal', setupTransactionTypeToggle);
    document.addEventListener('DOMContentLoaded', setupTransactionTypeToggle);
</script>

<script>
    const inventarisData = @json($inventaris);

    function updateTotalHarga() {
        const inventariId = document.getElementById('inventari_id').value;
        const jumlah = parseInt(document.getElementById('jumlah').value) || 0;

        const inventaris = inventarisData.find(item => item.id === inventariId);
        const harga = inventaris ? parseInt(inventaris.harga_jual) : 0;

        const total = jumlah * harga;
        document.getElementById('total_harga').value = total;
    }

    document.getElementById('inventari_id').addEventListener('change', updateTotalHarga);
    document.getElementById('jumlah').addEventListener('input', updateTotalHarga);
</script>
