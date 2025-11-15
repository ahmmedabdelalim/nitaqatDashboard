<x-filament::page>

    <div class="space-y-12 max-w-7xl mx-auto">

        {{-- Page Header --}}
        <div class="bg-gradient-to-r from-slate-800 to-slate-900 p-10 rounded-2xl text-white shadow-xl border border-slate-700">
            <h1 class="text-4xl font-bold tracking-tight mb-3">
                Database Tools
            </h1>
            <p class="text-lg text-slate-300">
                Manage database tables • Export data • Reset tables with confidence
            </p>
        </div>

        {{-- Backup Toggle --}}
        <div class="bg-white border border-gray-200 rounded-xl shadow-sm p-6">
            <label class="flex items-center space-x-4 cursor-pointer select-none">
                <input
                    type="checkbox"
                    wire:model.live="enableBackup"
                    class="w-6 h-6 text-indigo-600 rounded border-gray-300 focus:ring-indigo-500 focus:ring-2"
                >
                <span class="text-lg font-medium text-gray-800">
                    Enable automatic backup before resetting any table
                </span>
            </label>
        </div>

        {{-- Professional Table --}}
        <div class="bg-white rounded-xl shadow-lg border border-gray-200 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50 border-b border-gray-200">
                        <tr>
                            <th class="px-8 py-5 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                Table Name
                            </th>
                            <th class="px-8 py-5 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                Rows
                            </th>
                            <th class="px-8 py-5 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                Actions
                            </th>
                        </tr>
                    </thead>

                    <tbody class="bg-white divide-y divide-gray-100">
                        @foreach ($this->tables as $table)
                            <tr class="hover:bg-gray-50 transition-colors duration-150">
                                {{-- Table Name --}}
                                <td class="px-8 py-6 text-base font-medium text-gray-900 whitespace-nowrap">
                                    {{ $table }}
                                </td>

                                {{-- Row Count --}}
                                <td class="px-8 py-6 text-base text-gray-700 font-mono">
                                    {{ number_format($this->getTableCount($table)) }}
                                </td>

                                {{-- Actions --}}
                                <td class="px-8 py-6 text-base">
                                    <div class="flex items-center space-x-3">

                                        <x-filament::button
                                            size="sm"
                                            color="primary"
                                            icon="heroicon-o-document-arrow-down"
                                            wire:click="exportTableCsv('{{ $table }}')"
                                            class="shadow-sm hover:shadow-md transform hover:-translate-y-0.5 transition"
                                        >
                                            CSV
                                        </x-filament::button>

                                        <x-filament::button
                                            size="sm"
                                            color="success"
                                            icon="heroicon-o-document-arrow-down"
                                            wire:click="exportTableExcel('{{ $table }}')"
                                            class="shadow-sm hover:shadow-md transform hover:-translate-y-0.5 transition"
                                        >
                                            Excel
                                        </x-filament::button>

                                        <x-filament::button
                                            size="sm"
                                            color="danger"
                                            icon="heroicon-o-trash"
                                            onclick="confirmReset('{{ $table }}')"
                                            class="shadow-sm hover:shadow-md transform hover:-translate-y-0.5 transition"
                                        >
                                            Reset
                                        </x-filament::button>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            @if(count($this->tables) === 0)
                <div class="text-center py-12 text-gray-500">
                    <p class="text-lg">No tables found in the database.</p>
                </div>
            @endif
        </div>

    </div>

    {{-- Enhanced Confirmation Dialog (using native confirm with better message) --}}
    <script>
        function confirmReset(table) {
            const backupStatus = @json($this->enableBackup) ? 'A backup will be created automatically.' : 'NO BACKUP will be created.';

            if (confirm(
                `⚠️  RESET TABLE: ${table}\n\n` +
                `This action will delete all ${table} rows permanently.\n\n` +
                `${backupStatus}\n\n` +
                `Type "RESET ${table.toUpperCase()}" to confirm:`
            )) {
                const confirmation = prompt(`Type "RESET ${table.toUpperCase()}" to proceed:`);
                if (confirmation === `RESET ${table.toUpperCase()}`) {
                    @this.call('resetTable', table);
                    alert('Table reset initiated...');
                } else {
                    alert('Reset cancelled. Input did not match.');
                }
            }
        }
    </script>

</x-filament::page>
