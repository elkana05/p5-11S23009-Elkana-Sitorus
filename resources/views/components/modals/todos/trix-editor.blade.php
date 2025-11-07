@props(['id', 'value' => ''])

<div wire:ignore>
    <input id="{{ $id }}" type="hidden" name="content" value="{{ $value }}">
    <trix-editor input="{{ $id }}"></trix-editor>
</div>

@script
<script>
    document.addEventListener('trix-change', function(event) {
        if (event.target.id.startsWith('{{ $id }}')) {
            @this.set(event.target.getAttribute('wire:model.defer'), event.target.value);
        }
    });
</script>
@endscript