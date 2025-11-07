<form wire:submit.prevent="editTodo">
    <div class="modal fade" tabindex="-1" id="editTodoModal" wire:ignore.self>
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Ubah Catatan Keuangan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Judul</label>
                        <input type="text" class="form-control" wire:model="editForm.title">
                        @error('editForm.title')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Jumlah (Nominal)</label>
                        <input type="number" class="form-control" placeholder="Contoh: 50000" wire:model="editForm.amount">
                        @error('editForm.amount')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Jenis Catatan</label>
                        <select class="form-select" wire:model="editForm.type">
                            <option value="1">Pemasukan</option>
                            <option value="0">Pengeluaran</option>
                        </select>
                        @error('editForm.type')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Deskripsi</label>
                        <x-trix-editor id="edit_todo_description" wire:model="editForm.description" />
                        @error('editForm.description')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Tanggal</label>
                        <input type="date" class="form-control" wire:model="editForm.created_at">
                        @error('editForm.created_at')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </div>
        </div>
    </div>
</form>
