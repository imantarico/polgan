<form wire:submit.prevent="submit">
    <div class="flex justify-center mb-4">
        <img src="{{ asset('img/logo.png') }}" alt="Logo Polgan" class="w-16 h-16">
        <h1 class="font-bold text-xl my-1 text-center">ANGKET MAHASISWA BARU POLITEKNIK GANESHA MEDAN TAHUN 2025</h1>
    </div>
    <div class="mb-4">
        <hr class="leading-snug mb-4">
        {{ $this->form }}
    </div>
    <div class="flex justify-between mt-4">

        <a href="/" style="color: #1e40af; padding: 0.5rem 1rem; border-radius: 0.25rem;">
            Kembali
        </a>
        <x-filament::button type="submit" variant="primary">
            Mendaftar
        </x-filament::button>
    </div>

</form>
