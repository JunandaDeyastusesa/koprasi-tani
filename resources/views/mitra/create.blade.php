<!-- Modal Register -->
<div class="modal fade" id="addModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
    aria-labelledby="addModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content p-2">
            <div class="modal-header mb-2 pb-3">
                <h1 class="modal-title fs-5" id="addModalLabel">Tambah Mitra</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('mitras.store') }}" method="POST">
                    @csrf
                    <div class="row">
                        <div class="mb-3 col-md-12">
                            <label for="nama" class="form-label">Nama Mitra</label>
                            <input type="text" name="nama" id="nama"
                                class="form-control @error('nama') is-invalid @enderror" value="{{ old('nama') }}"
                                placeholder="Masukkan nama lengkap" required>
                            @error('nama')
                                <span class="text-danger small">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="mb-3 col-md-12">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" name="email" id="email"
                                class="form-control @error('email') is-invalid @enderror" value="{{ old('email') }}"
                                placeholder="Masukkan email" required>
                            @error('email')
                                <span class="text-danger small">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="mb-3 col-md-12">
                            <label for="no_hp" class="form-label">No Hp</label>
                            <input type="number" min="0" name="no_hp" id="no_hp"
                                class="form-control @error('no_hp') is-invalid @enderror" value="{{ old('no_hp') }}"
                                placeholder="Masukkan No Hp" required>
                            @error('no_hp')
                                <span class="text-danger small">{{ $message }}</span>
                            @enderror
                        </div>


                        <div class="mb-3 col-md-12">
                            <label for="alamat" class="form-label">Alamat</label>
                            <textarea name="alamat" id="alamat" class="form-control @error('alamat') is-invalid @enderror"
                                placeholder="Masukkan Alamat" required>{{ old('alamat') }}</textarea>
                            @error('alamat')
                                <span class="text-danger small">{{ $message }}</span>
                            @enderror
                        </div>

                    </div>

                    <div class="modal-footer border-0 d-flex justify-content-between p-0 mt-3">
                        <button type="button" class="btn btn-outline-secondary px-4"
                            data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary px-4">Daftar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<script>
    const noHpInput = document.getElementById('no_hp');
    noHpInput.addEventListener('input', function () {
        if (this.value.length > 12) {
            this.value = this.value.slice(0, 12);
        }
    });
</script>
