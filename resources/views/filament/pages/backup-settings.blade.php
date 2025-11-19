<x-filament::page>
    {{ $this->form }}

    <div class="mt-6 flex gap-3">
        <x-filament::button wire:click="save">Save Settings</x-filament::button>
        <x-filament::button color="secondary" wire:click="backupNow">Backup Now</x-filament::button>
    </div>
</x-filament::page>
