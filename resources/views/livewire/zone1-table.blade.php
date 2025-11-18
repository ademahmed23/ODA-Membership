<div>
    <!-- Woreda Filter -->
    <div class="mb-4">
        <label for="woredaFilter" class="form-label">Filter by Woreda</label>
        <select 
            class="form-select" 
            id="woredaFilter" 
            wire:model="selectedWoreda"
            wire:change="$refresh"
        >
            <option value="">All Woredas</option>
            @php
                $woredas = \App\Models\Zone1::distinct()
                            ->whereNotNull('woreda')
                            ->orderBy('woreda')
                            ->pluck('woreda');
            @endphp
            @foreach($woredas as $woreda)
                <option value="{{ $woreda }}">{{ $woreda }}</option>
            @endforeach
        </select>
    </div>

    <!-- PowerGrid Table -->
    <livewire:power-grid.zone1-table />
</div>