<?php

namespace App\Livewire\Forms; // Namespace ini sudah benar

use App\Models\Todo;
use Livewire\Attributes\Rule;
use Livewire\Form;

class EditTodoForm extends Form
{
    public $todoId;

    #[Rule('required|string|max:255', attribute: 'Judul')]
    public $title = '';

    #[Rule('required|numeric', attribute: 'Jumlah (Nominal)')]
    public $amount = 0;

    #[Rule('required|boolean', attribute: 'Jenis Catatan')]
    public $type = 0;

    #[Rule('nullable|string', attribute: 'Deskripsi')]
    public $description = '';

    #[Rule('required|date', attribute: 'Tanggal')]
    public $created_at = '';

    public function reset(...$properties)
    {
        parent::reset(...$properties);
        $this->type = 0; // Kembalikan ke default
    }
}