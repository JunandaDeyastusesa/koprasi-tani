<!-- Modal Tambah Produk -->
<div class="modal fade" id="addModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
    aria-labelledby="addModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content p-2">
            <div class="modal-header mb-2 pb-3">
                <h1 class="modal-title fs-5" id="addModalLabel">Tambah Inventaris</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('inventaris.store') }}" method="POST">
                    @csrf
                    <div class="row">
                        <div class="mb-3 col-md-6">
                            <label for="nama" class="form-label">Nama Produk</label>
                            <input type="text" name="nama" id="nama"
                                class="form-control @error('nama') is-invalid @enderror" value="{{ old('nama') }}"
                                placeholder="Masukkan nama produk" required>
                            @error('nama')
                                <span class="text-danger small">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="mb-3 col-md-6">
                            <label for="kategori" class="form-label">Kategori</label>
                            <input type="text" name="kategori" id="kategori"
                                class="form-control @error('kategori') is-invalid @enderror"
                                value="{{ old('kategori') }}" placeholder="Masukkan kategori" required>
                            @error('kategori')
                                <span class="text-danger small">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="mb-3 col-md-4">
                            <label for="harga_jual" class="form-label">Harga Jual</label>
                            <input type="number" min="0" name="harga_jual" id="harga_jual"
                                class="form-control @error('harga_jual') is-invalid @enderror"
                                value="{{ old('harga_jual') }}" placeholder="Masukkan harga jual" required>
                            @error('harga_jual')
                                <span class="text-danger small">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="mb-3 col-md-4">
                            <label for="harga_beli" class="form-label">Harga Beli</label>
                            <input type="number" min="0" name="harga_beli" id="harga_beli"
                                class="form-control @error('harga_beli') is-invalid @enderror"
                                value="{{ old('harga_beli') }}" placeholder="Masukkan harga beli" required>
                            @error('harga_beli')
                                <span class="text-danger small">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="mb-3 col-md-4">
                            <label for="jumlah" class="form-label">Jumlah</label>
                            <input type="number" min="0" name="jumlah" id="jumlah"
                                class="form-control @error('jumlah') is-invalid @enderror" value="{{ old('jumlah') }}"
                                placeholder="Masukkan jumlah stok" required>
                            @error('jumlah')
                                <span class="text-danger small">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="mb-3 col-md-12">
                            <label for="deskripsi" class="form-label">Deskripsi</label>
                            <textarea name="deskripsi" id="deskripsi" class="form-control @error('deskripsi') is-invalid @enderror"
                                placeholder="Masukkan deskripsi produk" required>{{ old('deskripsi') }}</textarea>
                            @error('deskripsi')
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
