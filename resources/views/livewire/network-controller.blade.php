<div class="space-y-6">
    <div>
        <flux:heading size="xl" level="1">NetShaper Control Engine</flux:heading>
        <flux:subheading>Manage background bandwidth quotas and connection profiling dynamically.</flux:subheading>
    </div>

    <flux:separator />

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <flux:card class="space-y-6">
            <div>
                <flux:heading size="lg">Bandwidth Limiter</flux:heading>
                <flux:subheading>Set absolute ceiling download limits below.</flux:subheading>
            </div>

            <flux:switch wire:model="isThrottled" label="Enable Speed Cap" description="Actively restrict interface adapter speeds" />

            <div class="space-y-2">
                <div class="flex justify-between text-sm text-zinc-500">
                    <span>Download Limit</span>
                    <span class="font-bold text-zinc-800 dark:text-white">{{ $downloadLimit }} Mbps</span>
                </div>
                <input
                    type="range"
                    wire:model="downloadLimit"
                    min="1"
                    max="200"
                    step="5"
                    class="w-full accent-primary" />
            </div>

            <flux:button variant="primary" wire:click="applyNetworkSettings" class="w-full">
                Apply Shaper Rules
            </flux:button>
        </flux:card>

        <flux:card class="space-y-6">
            <div>
                <flux:heading size="lg">Network Priority Profile</flux:heading>
                <flux:subheading>Instantly configure presets optimized for tasks.</flux:subheading>
            </div>

            <flux:radio.group wire:model="selectedProfile" variant="cards" class="flex flex-col gap-2">
                <flux:radio value="Gaming" label="Gaming Priority" description="Unrestricted latency, minimal packet-loss profiling." />
                <flux:radio value="Standard" label="Standard Mode" description="Balanced allocation across all local protocols." />
                <flux:radio value="Eco" label="Eco Throttle" description="Strictly clamps data to save mobile hotspot caps." />
            </flux:radio.group>
        </flux:card>
    </div>
</div>
