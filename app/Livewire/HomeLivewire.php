<?php

namespace App\Livewire;

use Livewire\Attributes\WithoutUrl;
use App\Livewire\Forms\AddTodoForm;
use App\Livewire\Forms\EditTodoForm;
use App\Models\Todo;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;
use Illuminate\Support\Facades\DB;

class HomeLivewire extends Component
{
    use WithPagination;
    use WithFileUploads;
    public $auth;
    protected $paginationTheme = 'bootstrap';

    // Menggunakan Form Objects
    public AddTodoForm $addForm;
    public EditTodoForm $editForm;
    
    // Properti untuk Hapus Catatan
    public $deleteTodoId;
    public $deleteTodoTitle;
    public $deleteTodoConfirmTitle;

    // Properti untuk Pencarian dan Filter
    public $search = '';
    public $filterType = '';
    public $startDate = ''; // Keep for general filtering
    public $endDate = ''; // Keep for general filtering

    public function mount()
    {
        $this->auth = Auth::user();
        // Inisialisasi tanggal pada form tambah dengan tanggal hari ini
        $this->addForm->created_at = now()->format('Y-m-d');
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingFilterType()
    {
        $this->resetPage();
    }

    public function updatingStartDate()
    {
        $this->resetPage();
    }

    public function updatingEndDate()
    {
        $this->resetPage();
    }

    // Lifecycle hook untuk menangani perubahan pada filter tanggal
    public function updated($property)
    {
        if ($property === 'startDate' || $property === 'endDate') {
            $this->updateChartData();
        }
    }

    public function resetDateFilter()
    {
        $this->reset('startDate', 'endDate');
        $this->updateChartData(); // Tambahkan ini untuk update chart saat filter direset
    }

    public function addTodo()
    {
        // Livewire akan secara otomatis mengisi data ke $this->addForm sebelum validate() dipanggil

        $this->addForm->validate();

        Todo::create([
            'user_id' => $this->auth->id,
            'title' => $this->addForm->title,
            'amount' => $this->addForm->amount,
            'type' => $this->addForm->type,
            'cover' => null,
            'description' => $this->addForm->description,
            'created_at' => $this->addForm->created_at,
            'updated_at' => $this->addForm->created_at,
        ]);
        $this->addForm->reset();
        $this->dispatch('close-modal', 'addTodoModal'); // Tetap tutup modal
        $this->dispatch('reset-trix', 'add_todo_description');

        $this->dispatch('show-alert', [
            'type' => 'success',
            'title' => 'Berhasil!',
            'message' => 'Catatan keuangan berhasil ditambahkan.',
        ]);

        $this->updateChartData();
    }

    public function prepareEditTodo($todoId)
    {
        $todo = Todo::find($todoId);
        if ($todo && $todo->user_id === $this->auth->id) {
            $this->editForm->todoId = $todo->id;
            $this->editForm->title = $todo->title;
            $this->editForm->amount = $todo->amount;
            $this->editForm->type = $todo->type;
            $this->editForm->description = $todo->description;
            $this->editForm->created_at = $todo->created_at->format('Y-m-d');
            
            $this->dispatch('open-modal', 'editTodoModal');
        }
    }

    public function editTodo()
    {
        $this->editForm->validate();

        $todo = Todo::find($this->editForm->todoId);
        if ($todo && $todo->user_id === $this->auth->id) {
            $todo->update([
                'title' => $this->editForm->title,
                'amount' => $this->editForm->amount,
                'type' => $this->editForm->type,
                'description' => $this->editForm->description,
                'cover' => $todo->cover, // Pastikan cover tidak diubah
                'created_at' => $this->editForm->created_at,
                'updated_at' => $this->editForm->created_at,
            ]);
        }
        $this->editForm->reset(); // Reset form setelah berhasil
        $this->dispatch('close-modal', 'editTodoModal'); // Tetap tutup modal
        $this->dispatch('show-alert', [
            'type' => 'success',
            'title' => 'Berhasil!',
            'message' => 'Catatan keuangan berhasil diperbarui.',
        ]);

        $this->updateChartData();
    }

    public function prepareDeleteTodo($todoId)
    {
        $todo = Todo::find($todoId);
        if ($todo && $todo->user_id === $this->auth->id) {
            $this->deleteTodoId = $todo->id;
            $this->deleteTodoTitle = $todo->title;
            $this->deleteTodoConfirmTitle = '';

            $this->dispatch('open-modal', 'deleteTodoModal');
        }
    }

    public function deleteTodo()
    {
        $todo = Todo::find($this->deleteTodoId);
        if ($todo && $todo->user_id === $this->auth->id) {
            // Validasi konfirmasi judul
            if ($this->deleteTodoConfirmTitle === $todo->title) {
                $todo->delete();
                $this->reset(['deleteTodoId', 'deleteTodoTitle', 'deleteTodoConfirmTitle']);
                $this->dispatch('close-modal', 'deleteTodoModal'); // Tetap tutup modal
                $this->dispatch('show-alert', [
                    'type' => 'success',
                    'title' => 'Berhasil!',
                    'message' => 'Catatan keuangan berhasil dihapus.',
                ]);

                $this->updateChartData();
            } else {
                // $this->addError('deleteTodoConfirmTitle', 'Konfirmasi judul tidak sesuai.');
                $this->dispatch('show-alert', [
                    'type' => 'error',
                    'title' => 'Gagal!',
                    'message' => 'Konfirmasi judul tidak sesuai. Catatan tidak dihapus.',
                ]);
            }
        }
    }

    public function updateChartData()
    {
        $query = $this->getFilteredBaseQuery();
        // Kirim event ke browser untuk update chart dengan data terbaru
        $this->dispatch('update-charts', [
            'totalIncome' => (clone $query)->where('type', 1)->sum('amount'),
            'totalExpense' => (clone $query)->where('type', 0)->sum('amount'),
        ]);
    }
    public function render()
    {
        // Dapatkan query dasar yang sudah difilter tanggal
        $query = $this->getFilteredBaseQuery();

        // Hitung total pemasukan dan pengeluaran berdasarkan query yang sudah difilter
        $totalIncome = (clone $query)->where('type', 1)->sum('amount');
        $totalExpense = (clone $query)->where('type', 0)->sum('amount');
        $balance = $totalIncome - $totalExpense;

        // Buat query terpisah untuk daftar catatan yang akan dipaginasi
        // karena filter pencarian dan jenis tidak boleh memengaruhi total saldo
        $recordsQuery = (clone $query);

        // Terapkan pencarian pada query yang difilter
        if ($this->search) {
            $recordsQuery->where('title', 'like', '%' . $this->search . '%');
        }

        // Terapkan filter jenis pada query yang difilter
        if ($this->filterType !== '') {
            $recordsQuery->where('type', $this->filterType);
        }
        $records = $recordsQuery->latest()->paginate(20);
        
        return view('livewire.home-livewire', [
            'records' => $records,
            'balance' => $balance,
            'totalIncome' => $totalIncome,
            'totalExpense' => $totalExpense,
            'theme' => session('theme', 'dark'), // Kirim tema ke view
        ]);
    }

    private function getFilteredBaseQuery()
    {
        $query = Todo::where('user_id', $this->auth->id);

        if ($this->startDate) {
            $query->whereDate('created_at', '>=', $this->startDate);
        }
        if ($this->endDate) {
            $query->whereDate('created_at', '<=', $this->endDate);
        }

        return $query;
    }
}