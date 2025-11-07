<div class="modal fade" tabindex="-1" id="addTodoModal" wire:ignore.self>
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Tambah Catatan Keuangan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form wire:submit="addTodo">
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Judul</label>
                        <input type="text" class="form-control" placeholder="Contoh: Gaji Bulanan"
                            wire:model="addForm.title">
                        @error('addForm.title')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Jenis Catatan</label>
                            <select class="form-select" wire:model="addForm.type">
                                <option value="">Pilih Jenis</option>
                                <option value="1">Pemasukan</option>
                                <option value="0">Pengeluaran</option>
                            </select>
                            @error('addForm.type')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Jumlah (Nominal)</label>
                            <div class="input-group">
                                <span class="input-group-text">Rp</span>
                                <input type="number" class="form-control" placeholder="Contoh: 5000000"
                                    wire:model="addForm.amount">
                            </div>
                            @error('addForm.amount')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Tanggal</label>
                            <input type="date" class="form-control" wire:model="addForm.created_at">
                            @error('addForm.created_at')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="mb-3" wire:ignore>
                        <label class="form-label">Deskripsi</label>
                        <input id="add_todo_description" type="hidden" name="content">
                        <trix-editor input="add_todo_description"
                            x-on:trix-change="$wire.set('addForm.description', $event.target.value)"></trix-editor>
                        @error('addForm.description')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">
                        <span wire:loading.remove wire:target="addTodo">Simpan</span>
                        <span wire:loading wire:target="addTodo">Menyimpan...</span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>