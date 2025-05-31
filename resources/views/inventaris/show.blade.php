<!-- Modal -->
<div class="modal fade" id="showModal" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content p-3">
            <div class="modal-header mb-2 pb-4">
                <h1 class="modal-title fs-5" id="staticBackdropLabel">Detail Inventaris</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="card border-0">
                    <div class="mb-4">
                        <label class="form-label mb-0">Nama Produk</label>
                        <p class="form-control-plaintext py-0 fs-4 fw-semibold">
                            {{ $inventaris->nama ?? '-' }}
                        </p>
                    </div>
                    <div class="row row-cols-2">
                        <div class="mb-3">
                            <label class="form-label mb-0">Kategori</label>
                            <p class="form-control-plaintext pt-0 fw-medium">{{ $inventaris->kategori ?? '-' }}</p>
                        </div>
                        <div class="mb-3">
                            <label class="form-label mb-0">Harga Jual</label>
                            <p class="form-control-plaintext pt-0 fw-medium">Rp.
                                {{ number_format($inventaris->harga_jual ?? 0, 0, ',', '.') }}</p>
                        </div>
                        <div class="mb-3">
                            <label class="form-label mb-0">Harga Beli</label>
                            <p class="form-control-plaintext pt-0 fw-medium">Rp.
                                {{ number_format($inventaris->harga_beli ?? 0, 0, ',', '.') }}</p>
                        </div>
                        <div class="mb-3">
                            <label class="form-label mb-0">Jumlah</label>
                            <p class="form-control-plaintext pt-0 fw-medium">{{ $inventaris->jumlah ?? '-' }}</p>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label mb-0">Deskripsi</label>
                        <p class="form-control-plaintext pt-0">{{ $inventaris->deskripsi ?? '-' }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
