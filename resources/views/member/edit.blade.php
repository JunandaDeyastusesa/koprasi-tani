<!-- Modal Edit -->
<div class="modal fade" id="editModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
    aria-labelledby="editModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content p-3">
            <div class="modal-header mb-2 pb-3">
                <h1 class="modal-title fs-5" id="editModalLabel">Edit Member</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('members.update', ['member' => $user->id]) }}" method="POST" id="formEditMember">

                    {{-- <form action="{{ route('member.update', ['user' => $user->id]) }}" method="POST" id="formEditMember"> --}}
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="id" id="edit_id">

                    <div class="row">
                        <div class="mb-3 col-md-12">
                            <label for="edit_name" class="form-label">Nama Lengkap</label>
                            <input type="text" name="name" id="edit_name"
                                class="form-control @error('name') is-invalid @enderror"
                                placeholder="Masukkan nama lengkap" value="{{ old('name', $user->name) }}" required>
                            @error('name')
                                <span class="text-danger small">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="mb-3 col-md-6">
                            <label for="edit_email" class="form-label">Email</label>
                            <input type="email" name="email" id="edit_email"
                                class="form-control @error('email') is-invalid @enderror" placeholder="Masukkan email"
                                value="{{ old('email', $user->email) }}" required>
                            @error('email')
                                <span class="text-danger small">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="mb-3 col-md-6">
                            <label for="edit_username" class="form-label">Username</label>
                            <input type="text" name="username" id="edit_username"
                                class="form-control @error('username') is-invalid @enderror"
                                placeholder="Masukkan username" value="{{ old('username', $user->username) }}" required>
                            @error('username')
                                <span class="text-danger small">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="mb-3 col-md-6">
                            <label for="edit_password" class="form-label">Kata Sandi (Opsional)</label>
                            <input type="password" name="password" id="edit_password"
                                class="form-control @error('password') is-invalid @enderror"
                                placeholder="Biarkan kosong jika tidak diubah">
                            @error('password')
                                <span class="text-danger small">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="mb-3 col-md-6">
                            <label for="edit_password_confirmation" class="form-label">Konfirmasi Kata Sandi</label>
                            <input type="password" name="password_confirmation" id="edit_password_confirmation"
                                class="form-control" placeholder="Ulangi kata sandi">
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
