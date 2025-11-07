<form class="mt-3" data-bs-theme="{{ $theme }}" wire:submit.prevent="editCoverTodo">
    <div class="card">
        <div class="card-header">
            <a href="{{ route('app.home') }}" class="text-decoration-none" wire:navigate>
                &lt; Kembali ke Daftar
            </a>
        </div>
        <div class="card-body">
            <h2 class="card-title">{{ $todo->title }}</h2>
            <div class="mb-3">
                @if ($todo->type == 1)
                    <span class="badge bg-success fs-6">Pemasukan</span>
                @else
                    <span class="badge bg-danger fs-6">Pengeluaran</span>
                @endif
            </div>

            <div class="row mb-4">
                <div class="col-md-6">
                    <p class="mb-1"><strong>Jumlah:</strong></p>
                    <h4>Rp {{ number_format($todo->amount, 0, ',', '.') }}</h4>
                </div>
                <div class="col-md-6">
                    <p class="mb-1"><strong>Tanggal Dibuat:</strong></p>
                    <h4>{{ $todo->created_at->format('d F Y') }}</h4>
                </div>
            </div>

            <hr>

            <h5 class="mb-3">Deskripsi:</h5>
            <div class="trix-content">{!! $todo->description !!}</div>

            <hr>

            <h5 class="mb-3">Lampiran</h5>
            @if ($todo->cover)
                <div class="mb-3">
                    <img src="{{ asset('storage/' . $todo->cover) }}" alt="Bukti Lampiran" class="img-fluid rounded" style="max-height: 300px;">
                </div>
                <button class="btn btn-outline-warning" data-bs-toggle="modal" data-bs-target="#editCoverTodoModal">
                    <i class="bi bi-pencil-square"></i> Ubah Bukti
                </button>
                <button class="btn btn-outline-danger" wire:click="deleteCover"
                    wire:confirm="Apakah Anda yakin ingin menghapus bukti ini?">
                    <i class="bi bi-trash"></i> Hapus Bukti
                </button>
            @else
                <div class="alert alert-secondary">
                    Tidak ada bukti yang dilampirkan.
                </div>
                <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#editCoverTodoModal">
                    <i class="bi bi-upload"></i> Tambah Bukti
                </button>
            @endif
        </div>
    </div>
    <x-modals.todos.edit-cover :editCoverTodoFile="$editCoverTodoFile" />
</form>