<!-- Modal -->
<div class="modal fade" id="showModal" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content p-3">
            <div class="modal-header mb-2 pb-4">
                <h1 class="modal-title fs-5" id="staticBackdropLabel">Detail Transaksi</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="card border-0">

                    <div class="row row-cols-2">
                        <div class="mb-3">
                            <label class="form-label mb-0">Nama</label>
                            <p class="form-control-plaintext pt-0 fs-5 fw-medium">{{ $transaksi->mitra->nama ?? $transaksi->user->name ??'-' }}
                            </p>
                        </div>
                        <div class="mb-3">
                            <label class="form-label mb-0">Nama Barang</label>
                            <p class="form-control-plaintext pt-0 fs-5 fw-medium">{{ $transaksi->inventaris->nama ?? '-' }}
                            </p>
                        </div>
                        <div class="mb-3">
                            <label class="form-label mb-0">Jumlah</label>
                            <p class="form-control-plaintext pt-0 fw-medium">{{ $transaksi->jumlah ?? '-' }}</p>
                        </div>
                        <div class="mb-3">
                            <label class="form-label mb-0">Total harga</label>
                            <p class="form-control-plaintext pt-0 fw-medium">Rp.
                                {{ number_format($transaksi->total_harga ?? 0, 0, ',', '.') }}</p>
                        </div>
                        <div class="mb-3">
                            <label class="form-label mb-0">Tanggal Transaksi</label>
                            <p class="form-control-plaintext pt-0 fw-medium">Rp.
                                {{ $transaksi->tgl_transaksi }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
