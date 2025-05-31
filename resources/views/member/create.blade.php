<!-- Modal Register -->
<div class="modal fade" id="registerModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
    aria-labelledby="registerModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content p-3">
            <div class="modal-header mb-2 pb-3">
                <h1 class="modal-title fs-5" id="registerModalLabel">Tambah Member</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('members.store') }}" method="POST">
                    @csrf
                    <div class="row">
                        <div class="mb-3 col-md-12">
                            <label for="name" class="form-label">Nama Lengkap</label>
                            <input type="text" name="name" id="name"
                                class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}"
                                placeholder="Masukkan nama lengkap" required>
                            @error('name')
                                <span class="text-danger small">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="mb-3 col-md-6">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" name="email" id="email"
                                class="form-control @error('email') is-invalid @enderror" value="{{ old('email') }}"
                                placeholder="Masukkan email" required>
                            @error('email')
                                <span class="text-danger small">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="mb-3 col-md-6">
                            <label for="username" class="form-label">Username</label>
                            <input type="text" name="username" id="username"
                                class="form-control @error('username') is-invalid @enderror"
                                value="{{ old('username') }}" placeholder="Masukkan username" required>
                            @error('username')
                                <span class="text-danger small">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="mb-3 col-md-6">
                            <div class="form-group">
                                <label for="role" class="pb-2">Pilih Role</label>
                                <select name="role" id="role"
                                    class="form-select @error('role') is-invalid @enderror" required>
                                    <option value="" disabled selected>Pilih Role</option>
                                    <option value="Member">Member</option>
                                    <option value="Admin">Admin</option>
                                </select>
                                @error('role')
                                    <span class="text-danger small">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="mb-3 col-md-6">
                            <label for="password" class="form-label">Kata Sandi</label>
                            <input type="password" name="password" id="password"
                                class="form-control @error('password') is-invalid @enderror"
                                placeholder="Masukkan kata sandi" required>
                            @error('password')
                                <span class="text-danger small">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="mb-3 col-md-6">
                            <label for="password_confirmation" class="form-label">Konfirmasi Kata Sandi</label>
                            <input type="password" name="password_confirmation" id="password_confirmation"
                                class="form-control" placeholder="Ulangi kata sandi" required>
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
