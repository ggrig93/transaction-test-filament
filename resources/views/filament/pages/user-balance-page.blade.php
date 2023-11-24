<x-filament::app-header :title="$this->title" />

<x-filament::app-content>
    <x-filament::card>
        <x-filament::table
            :records="$records"
            :recordActions="[
                'view' => 'users.transactions',
                // Add other actions as needed
            ]"
        />
    </x-filament::card>
</x-filament::app-content>
