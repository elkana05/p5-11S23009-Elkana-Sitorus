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
    public $amount = '';

    #[Rule('required|boolean', attribute: 'Jenis Catatan')]
    public $type = 0;

    #[Rule('nullable|string', attribute: 'Deskripsi')]
    public $description = '';

    public $oldCover;

    #[Rule('nullable|image|max:2048', attribute: 'Bukti Baru')]
    public $newCover;

}