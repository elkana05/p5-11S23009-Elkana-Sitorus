<?php

namespace App\Livewire\Forms; // Namespace ini sudah benar

use Livewire\Attributes\Rule;
use Livewire\Attributes\WithoutUrl;
use Livewire\Form;

class AddTodoForm extends Form
{
    #[Rule('required|string|max:255', attribute: 'Judul')]
    public $title = '';

    #[Rule('required|numeric', attribute: 'Jumlah (Nominal)')]
    public $amount = ''; // Pastikan ini juga diinisialisasi dengan nilai default yang sesuai, misalnya 0

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