<div class="bg-white dark:bg-zinc-900 rounded-2xl shadow-xs border border-zinc-100 dark:border-zinc-800 p-8">
    <div class="mb-6">
        <flux:heading size="lg">Speed Test History</flux:heading>
        <flux:subheading>Your last 10 speed tests</flux:subheading>
    </div>

    @if ($tests->count() > 0)
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead class="border-b border-zinc-200 dark:border-zinc-700">
                    <tr>
                        <th class="text-left py-3 px-4 font-semibold text-zinc-700 dark:text-zinc-300">Speed</th>
                        <th class="text-left py-3 px-4 font-semibold text-zinc-700 dark:text-zinc-300">Status</th>
                        <th class="text-left py-3 px-4 font-semibold text-zinc-700 dark:text-zinc-300">Date/Time</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-zinc-200 dark:divide-zinc-700">
                    @foreach ($tests as $test)
                        <tr class="hover:bg-zinc-50 dark:hover:bg-zinc-800 transition">
                            <td class="py-4 px-4">
                                <span class="font-semibold text-lg text-zinc-900 dark:text-white">
                                    {{ $test->download_speed }}
                                </span>
                                <span class="text-zinc-500 ml-2">Mbps</span>
                            </td>
                            <td class="py-4 px-4">
                                @if ($test->status === 'completed')
                                    <flux:badge variant="success" size="sm">Completed</flux:badge>
                                @elseif ($test->status === 'error')
                                    <flux:badge variant="danger" size="sm">Error</flux:badge>
                                @else
                                    <flux:badge variant="warning" size="sm">Aborted</flux:badge>
                                @endif
                            </td>
                            <td class="py-4 px-4 text-zinc-500">
                                {{ $test->created_at->format('M d, Y H:i') }}
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @else
        <div class="text-center py-12">
            <div class="w-12 h-12 mx-auto mb-4">
                <svg class="w-12 h-12 text-zinc-300 dark:text-zinc-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16l2.879-2.879m0 0a3 3 0 104.243-4.243m-4.243 4.243L3.879 9m6.364 5.636l5.243-5.243m0 0a3 3 0 104.243-4.243" />
                </svg>
            </div>
            <p class="text-zinc-500 dark:text-zinc-400">No speed tests yet. Run your first test above!</p>
        </div>
    @endif
</div>
