<?php

namespace App\Livewire;

use App\Models\Todo;
use Livewire\Component;
use Livewire\Attributes\Layout;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Storage;

#[Layout('layouts.app')]
class TodoDetailLivewire extends Component
{
    public Todo $todo;
    public $editCoverTodoFile;

    use WithFileUploads;
    public function mount($todo_id)
    {
        $this->todo = Todo::where('user_id', auth()->id())->findOrFail($todo_id);
    }

    public function render()
    {
        return view('livewire.todo-detail-livewire', [
            'theme' => session('theme', 'dark'),
        ]);
    }

    public function editCoverTodo()
    {
        $this->validate([
            'editCoverTodoFile' => 'required|image|max:2048',  // 2MB Max
        ]);

        if ($this->editCoverTodoFile) {
            // Hapus cover lama jika ada
            if ($this->todo->cover && Storage::disk('public')->exists($this->todo->cover)) {
                Storage::disk('public')->delete($this->todo->cover);
            }

            $userId = auth()->id();
            $dateNumber = now()->format('YmdHis');
            $extension = $this->editCoverTodoFile->getClientOriginalExtension();
            $filename = $userId . '_' . $dateNumber . '.' . $extension;
            $path = $this->editCoverTodoFile->storeAs('covers', $filename, 'public');
            $this->todo->cover = $path;
            $this->todo->save();
        }

        $this->reset(['editCoverTodoFile']);

        $this->dispatch('close-modal', id: 'editCoverTodoModal');
    }

    public function deleteCover()
    {
        if ($this->todo && $this->todo->cover) {
            // Hapus file dari storage
            if (Storage::disk('public')->exists($this->todo->cover)) {
                Storage::disk('public')->delete($this->todo->cover);
            }

            // Update database
            $this->todo->cover = null;
            $this->todo->save();

            // Kirim notifikasi sukses
            $this->dispatch('show-alert', [
                'type' => 'success', 'title' => 'Berhasil!', 'message' => 'Bukti telah dihapus.',
            ]);
        }
    }
}