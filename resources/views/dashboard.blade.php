<x-layouts::app.sidebar :title="__('Speed Test')">
    <div class="flex flex-col gap-8 p-6">
        <div class="bg-white dark:bg-zinc-900 rounded-2xl shadow-xs border border-zinc-100 dark:border-zinc-800">
            <livewire:speed-tester />
        </div>

        <div class="bg-white dark:bg-zinc-900 rounded-2xl shadow-xs border border-zinc-100 dark:border-zinc-800">
            <livewire:network-controller />
        </div>

        <livewire:speed-test-history-view />
    </div>
</x-layouts::app.sidebar>
