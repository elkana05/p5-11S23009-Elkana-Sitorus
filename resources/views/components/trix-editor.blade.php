@props(['id', 'value' => ''])

<div
    wire:ignore
    {{ $attributes->whereDoesntStartWith('wire:model') }}
>
    <input id="{{ $id }}" type="hidden" name="content" value="{{ $value }}">
    <trix-editor input="{{ $id }}" class="form-control"></trix-editor>
</div>

@script
<script>
    document.addEventListener('trix-change', (event) => {
        if (event.target.id.startsWith('{{ $id }}')) {
            @this.set('{{ $attributes->get('wire:model') }}', event.target.value);
        }
    });

    Livewire.on('reset-trix', (id) => {
        if (id === '{{ $id }}') {
            const trixEditor = document.querySelector(`trix-editor[input='{{ $id }}']`);
            trixEditor.editor.loadHTML('');
        }
    });
</script>
@endscript