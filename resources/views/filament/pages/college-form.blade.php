<x-filament-panels::page>
    <form wire:submit.prevent="submit">
        {{ $this->form }}
        <x-filament::button type="submit">
            Simpan
        </x-filament::button>
    </form>
</x-filament-panels::page>
