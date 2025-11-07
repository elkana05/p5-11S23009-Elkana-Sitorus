@props(['coverUrl' => null])

<div class="modal fade" tabindex="-1" id="viewCoverModal" wire:ignore.self>
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Bukti Lampiran</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body text-center">
                @if ($coverUrl)
                    <img src="{{ asset('storage/' . $coverUrl) }}" alt="Bukti Lampiran" class="img-fluid rounded">
                @else
                    <p>Gambar tidak ditemukan.</p>
                @endif
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>