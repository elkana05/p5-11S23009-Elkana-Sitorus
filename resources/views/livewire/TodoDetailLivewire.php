<?php

namespace App\Livewire;

use App\Models\Todo;
use Livewire\Component;
use Livewire\Attributes\Layout;

#[Layout('components.layouts.app')]
class TodoDetailLivewire extends Component
{
    public Todo $todo;

    public function mount($todo_id)
    {
        $this->todo = Todo::where('user_id', auth()->id())->findOrFail($todo_id);
    }

    public function render()
    {
        return view('livewire.todo-detail-livewire');
    }
}