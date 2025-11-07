<?php

namespace App\Livewire\Forms;

use Livewire\Attributes\Rule;
use Livewire\Attributes\WithoutUrl;
use Livewire\Form;

class AddTodoForm extends Form
{
    #[Rule('required|string|max:255', attribute: 'Judul')]
    public $title = '';

    #[Rule('required|numeric', attribute: 'Jumlah (Nominal)')]
    public $amount = '';

    #[Rule('required|boolean', attribute: 'Jenis Catatan')]
    public $type = 0;

    #[Rule('nullable|string', attribute: 'Deskripsi')]
    #[WithoutUrl]
    public $description = '';

    #[Rule('nullable|image|max:2048', attribute: 'Bukti')]
    public $cover;

    public function reset()
    {
        parent::reset();
        $this->type = 0; // Kembalikan ke default
    }
}