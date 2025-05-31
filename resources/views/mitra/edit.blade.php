<!-- Modal Edit -->
<div class="modal fade" id="editModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
    aria-labelledby="editModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content p-2">
            <div class="modal-header mb-2 pb-3">
                <h1 class="modal-title fs-5" id="editModalLabel">Edit Mitra</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('mitras.update', ['mitra' => $mitra->id]) }}" method="POST" id="formEditMitra">
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="id" id="edit_id">

                    <div class="row">
                        <div class="mb-3 col-md-12">
                            <label for="edit_nama" class="form-label">Nama Mitra</label>
                            <input type="text" name="nama" id="edit_nama"
                                class="form-control @error('nama') is-invalid @enderror"
                                value="{{ old('nama', $mitra->nama) }}" placeholder="Masukkan nama perusahaan" required>
                            @error('nama')
                                <span class="text-danger small">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="mb-3 col-md-12">
                            <label for="edit_email" class="form-label">Email</label>
                            <input type="email" name="email" id="edit_email"
                                class="form-control @error('email') is-invalid @enderror"
                                value="{{ old('email', $mitra->email) }}" placeholder="Masukkan email" required>
                            @error('email')
                                <span class="text-danger small">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="mb-3 col-md-12">
                            <label for="edit_no_hp" class="form-label">No Hp</label>
                            <input type="number" min="0" name="no_hp" id="edit_no_hp"
                                class="form-control @error('no_hp') is-invalid @enderror"
                                value="{{ old('no_hp', $mitra->no_hp) }}" placeholder="Masukkan No Hp" required>
                            @error('no_hp')
                                <span class="text-danger small">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="mb-3 col-md-12">
                            <label for="edit_alamat" class="form-label">Alamat</label>
                            <textarea name="alamat" id="edit_alamat" class="form-control @error('alamat') is-invalid @enderror"
                                placeholder="Masukkan Alamat" required>{{ old('alamat', $mitra->alamat) }}</textarea>
                            @error('alamat')
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

<script>
    const editNoHpInput = document.getElementById('edit_no_hp');
    editNoHpInput.addEventListener('input', function() {
        if (this.value.length > 13) {
            this.value = this.value.slice(0, 13);
        }
    });
</script>
