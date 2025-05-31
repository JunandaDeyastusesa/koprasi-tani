<!-- Modal Edit Produk -->
<div class="modal fade" id="editModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
    aria-labelledby="editModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content p-2">
            <div class="modal-header mb-2 pb-3">
                <h1 class="modal-title fs-5" id="editModalLabel">Edit Inventaris</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('inventaris.update', ['inventari' => $inventaris->id ?? '']) }}" method="POST"
                    id="formEditProduk">
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="id" id="edit_id" value="">

                    <div class="row">
                        <div class="mb-3 col-md-6">
                            <label for="edit_nama" class="form-label">Nama Produk</label>
                            <input type="text" name="nama" id="edit_nama"
                                class="form-control @error('nama') is-invalid @enderror"
                                placeholder="Masukkan nama produk" required value="{{ old('nama', $inventaris->nama ?? '') }}">
                            @error('nama')
                                <span class="text-danger small">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="mb-3 col-md-6">
                            <label for="edit_kategori" class="form-label">Kategori</label>
                            <input type="text" name="kategori" id="edit_kategori"
                                class="form-control @error('kategori') is-invalid @enderror"
                                placeholder="Masukkan kategori (Opsional)" value="{{ old('kategori', $inventaris->kategori ?? '') }}">
                            @error('kategori')
                                <span class="text-danger small">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="mb-3 col-md-4">
                            <label for="edit_harga_jual" class="form-label">Harga Jual</label>
                            <input type="number" min="0" name="harga_jual" id="edit_harga_jual"
                                class="form-control @error('harga_jual') is-invalid @enderror"
                                placeholder="Masukkan harga jual" required value="{{ old('harga_jual', $inventaris->harga_jual ?? '') }}">
                            @error('harga_jual')
                                <span class="text-danger small">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="mb-3 col-md-4">
                            <label for="edit_harga_beli" class="form-label">Harga Beli</label>
                            <input type="number" min="0" name="harga_beli" id="edit_harga_beli"
                                class="form-control @error('harga_beli') is-invalid @enderror"
                                placeholder="Masukkan harga beli" required value="{{ old('harga_beli', $inventaris->harga_beli ?? '') }}">
                            @error('harga_beli')
                                <span class="text-danger small">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="mb-3 col-md-4">
                            <label for="edit_jumlah" class="form-label">Jumlah</label>
                            <input type="number" min="0" name="jumlah" id="edit_jumlah"
                                class="form-control @error('jumlah') is-invalid @enderror"
                                placeholder="Masukkan jumlah stok" required value="{{ old('jumlah', $inventaris->jumlah ?? '') }}">
                            @error('jumlah')
                                <span class="text-danger small">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="mb-3 col-md-12">
                            <label for="edit_deskripsi" class="form-label">Deskripsi</label>
                            <textarea name="deskripsi" id="edit_deskripsi" class="form-control @error('deskripsi') is-invalid @enderror"
                                placeholder="Masukkan deskripsi produk (Opsional)">{{ old('deskripsi', $inventaris->deskripsi ?? '') }}</textarea>
                            @error('deskripsi')
                                <span class="text-danger small">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <div class="modal-footer border-0 d-flex justify-content-between p-0 mt-3">
                        <button type="button" class="btn btn-outline-secondary px-4"
                            data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary px-4">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
