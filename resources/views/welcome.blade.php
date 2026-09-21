<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>NetShaper Internet Speed Test</title>
    <link rel="icon" href="/netshaper-favicon.svg" type="image/svg+xml">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
    <style>
        [x-cloak] {
            display: none !important;
        }
    </style>
</head>

<body class="min-h-screen overflow-hidden bg-[#f4f1eb] text-[#191b1a] antialiased">
    <main
        x-data="speedTest()"
        x-init="init()"
        class="relative flex min-h-screen flex-col items-center justify-center px-6 py-8">
        <div class="pointer-events-none absolute inset-0 bg-[radial-gradient(circle_at_50%_42%,rgba(255,255,255,0.95),transparent_42%)]"></div>

        <div class="relative flex w-full max-w-3xl flex-col items-center">
            <div class="mb-16 flex items-center gap-3 text-sm font-bold uppercase tracking-[0.3em] text-[#59645d]">
                <span class="h-2.5 w-2.5 rounded-full" :class="isOnline ? 'bg-[#1f9d68]' : 'bg-[#d45b4c]'"></span>
                <span>NetShaper</span>
            </div>

            <section class="text-center" aria-live="polite">
                <p class="mb-5 text-sm font-medium uppercase tracking-[0.24em] text-[#788078]" x-text="statusLabel"></p>
                <div class="flex items-end justify-center gap-4 sm:gap-6">
                    <span class="font-mono text-[clamp(5rem,22vw,13rem)] font-light leading-[0.78] tracking-[-0.08em] text-[#191b1a]" x-text="speed">0.0</span>
                    <span class="mb-1 text-xl font-semibold uppercase tracking-[0.12em] text-[#788078] sm:mb-3 sm:text-3xl">Mbps</span>
                </div>
            </section>

            <button
                type="button"
                class="mt-16 flex h-16 w-16 items-center justify-center rounded-full bg-[#191b1a] text-[#f4f1eb] shadow-[0_12px_30px_rgba(25,27,26,0.18)] transition hover:scale-105 hover:bg-[#2d3931] disabled:cursor-not-allowed disabled:opacity-60"
                @click="toggleTest()"
                :disabled="!isOnline"
                :aria-label="testing ? 'Stop speed test' : 'Start speed test'">
                <svg x-show="!testing" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M5 12h14m-7-7 7 7-7 7" />
                </svg>
                <svg x-cloak x-show="testing" class="h-6 w-6 animate-spin" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M12 4v2m0 12v2M4 12h2m12 0h2m-3.66-5.66-1.42 1.42m-8.48 8.48-1.42 1.42m0-11.32 1.42 1.42m8.48 8.48 1.42 1.42" />
                </svg>
            </button>

            <p x-cloak x-show="errorMessage" class="mt-8 max-w-sm text-center text-sm text-[#b34c40]" x-text="errorMessage"></p>
            <p class="mt-20 text-center text-xs tracking-wide text-[#929991]" x-text="connectionLabel"></p>
            <p class="mt-2 text-center text-[11px] text-[#aaa69d]" x-text="networkName"></p>
        </div>
    </main>

    @livewireScripts
    <script>
        function speedTest() {
            return {
                isOnline: navigator.onLine,
                testing: false,
                speed: '0.0',
                statusLabel: 'Ready to measure your connection',
                connectionLabel: 'Waiting for a connection',
                networkName: 'Network name is hidden by your browser',
                errorMessage: '',
                controller: null,
                measurementUrl: 'https://speed.cloudflare.com/__down?bytes=25000000',

                init() {
                    this.updateConnectionLabel();
                    window.addEventListener('online', () => {
                        this.isOnline = true;
                        this.errorMessage = '';
                        this.updateConnectionLabel();
                    });
                    window.addEventListener('offline', () => {
                        this.isOnline = false;
                        this.stopTest();
                        this.statusLabel = 'No internet connection';
                        this.connectionLabel = 'Reconnect to measure speed';
                    });
                    this.startTest();
                },

                updateConnectionLabel() {
                    const network = navigator.connection;
                    if (!this.isOnline) {
                        this.connectionLabel = 'Reconnect to measure speed';
                        this.networkName = 'Network name is hidden by your browser';
                        return;
                    }

                    const connectionType = network?.type ? network.type.toUpperCase() : 'INTERNET';
                    const speedType = network?.effectiveType ? network.effectiveType.toUpperCase() : 'SPEED UNKNOWN';
                    this.connectionLabel = `${connectionType} | ${speedType}`;
                    this.networkName = 'Wi-Fi name and SIM line name are hidden by browser security';
                },

                toggleTest() {
                    this.testing ? this.stopTest() : this.startTest();
                },

                stopTest() {
                    this.controller?.abort();
                    this.controller = null;
                    this.testing = false;
                    if (!this.isOnline) this.speed = '0.0';
                },

                async startTest() {
                    if (!this.isOnline || this.testing) return;
                    this.testing = true;
                    this.speed = '0.0';
                    this.errorMessage = '';
                    this.statusLabel = 'Measuring download speed';
                    this.controller = new AbortController();

                    try {
                        const response = await fetch(`${this.measurementUrl}&cache=${Date.now()}`, {
                            cache: 'no-store',
                            signal: this.controller.signal,
                        });
                        if (!response.ok || !response.body) throw new Error('Unable to read test stream');

                        const reader = response.body.getReader();
                        const startedAt = performance.now();
                        let receivedBytes = 0;

                        while (true) {
                            const {
                                done,
                                value
                            } = await reader.read();
                            if (done) break;
                            receivedBytes += value.length;
                            const seconds = (performance.now() - startedAt) / 1000;
                            if (seconds > 0) this.speed = ((receivedBytes * 8) / seconds / 1000000).toFixed(1);
                        }

                        const seconds = (performance.now() - startedAt) / 1000;
                        if (receivedBytes === 0 || seconds <= 0) throw new Error('No data received');
                        this.speed = ((receivedBytes * 8) / seconds / 1000000).toFixed(1);
                        this.statusLabel = 'Your measured download speed';
                    } catch (error) {
                        if (error.name !== 'AbortError') {
                            this.errorMessage = 'The test could not reach the measurement server.';
                            this.statusLabel = 'Connection could not be measured';
                        }
                    } finally {
                        this.testing = false;
                        this.controller = null;
                        this.updateConnectionLabel();
                    }
                },
            };
        }
    </script>
</body>

</html>
