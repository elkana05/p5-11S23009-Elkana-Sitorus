<form wire:submit.prevent="register">
    <div class="card mx-auto bg-dark-subtle shadow-lg rounded-4" style="max-width: 380px;">
        <div class="card-body">
            <div>
                <div class="text-center">
                    <i class="bi bi-person-vcard-fill text-warning" style="font-size: 3rem;"></i>
                    <h2 class="mt-2">Mendaftar</h2>
                </div>
                <hr>
                {{-- Nama --}}
                <div class="form-group mb-3">
                    <label class="form-label">Nama</label>
                    <input type="text" class="form-control" wire:model="name">
                    @error('name')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                {{-- Alamat Email --}}
                <div class="form-group mb-3">
                    <label class="form-label">Email</label>
                    <input type="email" class="form-control" wire:model="email">
                    @error('email')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                {{-- Kata Sandi --}}
                <div class="form-group mb-3">
                    <label class="form-label">Kata Sandi</label>
                    <input type="password" class="form-control" wire:model="password">
                    @error('password')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                {{-- Tombol Kirim --}}
                <div class="d-grid mt-4">
                    <button type="submit" class="btn btn-warning">Daftar</button>
                </div>

                <hr>
                <p class="text-center mb-0">Sudah memiliki akun? <a href="{{ route('auth.login') }}" wire:navigate>Masuk</a></p>
            </div>
        </div>
    </div>
</form>
