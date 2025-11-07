<?php

namespace App\Livewire\Forms; // Namespace ini sudah benar

use Livewire\Attributes\Rule;
use Livewire\Attributes\WithoutUrl;
use Livewire\Form;

class AddTodoForm extends Form
{
    #[Rule('required|string|max:255', attribute: 'Judul')]
    public $title = '';

    #[Rule('required|numeric|min:0', attribute: 'Jumlah (Nominal)')]
    public $amount = '';

    #[Rule('required|in:0,1', attribute: 'Jenis Catatan')]
    public $type = 0;

    #[Rule('nullable|string', attribute: 'Deskripsi')]
    #[WithoutUrl]
    public $description = '';

    #[Rule('required|date', attribute: 'Tanggal')]
    public $created_at = '';

    public function reset(...$properties)
    {
        parent::reset(...$properties);
    }
}