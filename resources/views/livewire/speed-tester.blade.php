<div x-data="speedTest()" class="flex flex-col items-center justify-between min-h-screen bg-white text-zinc-800 font-sans p-6 relative">

    <!-- Top Branding / Logo Zone -->
    <div class="mt-2 flex flex-col items-center gap-1">
        <div class="flex flex-col items-center select-none">
            <!-- Customized Speedometer Graphic mimicking Fast.com -->
            <svg style="width: 50px; height: 25px;" viewBox="0 0 100 50" fill="none">
                <path d="M10 40 C 10 15, 90 15, 90 40" stroke="#dc2626" stroke-width="6" fill="none" stroke-linecap="round" />
                <path d="M30 40 C 30 25, 70 25, 70 40" stroke="#dc2626" stroke-width="4" fill="none" stroke-linecap="round" />
                <polygon points="50,40 45,20 55,20" fill="black" />
            </svg>
            <span class="text-lg font-black tracking-tighter text-black">NETSHAPER</span>
        </div>
    </div>

    <!-- Middle Main Speed Counter Area (Exactly like FAST.com) -->
    <div class="flex flex-col items-center justify-center py-12">
        <p class="text-lg font-normal text-zinc-900 mb-2 select-none">Your Internet speed is</p>

        <div class="flex items-baseline justify-center select-none tracking-tighter relative">
            <!-- Massive Real-Time Number Counter -->
            <span class="text-8xl font-light text-zinc-950 leading-none" x-text="displaySpeed">0</span>

            <div class="flex flex-col items-start ml-4">
                <!-- Data Unit -->
                <span class="text-3xl font-medium text-zinc-800" x-text="unit">Mbps</span>
                <!-- Green Refresh/Stop Button -->
                <button @click="toggleTest()" class="mt-3 p-2 rounded-full border-2 border-zinc-200 hover:border-green-500 transition-all duration-200 focus:outline-none cursor-pointer">
                    <!-- Spinning icon while testing -->
                    <svg x-show="isRunning" class="w-6 h-6 text-zinc-400 animate-spin" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 1121.253 8H18" />
                    </svg>
                    <!-- Green circular refresh icon when idle -->
                    <svg x-show="!isRunning" class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 1121.253 8H18" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Bottom Actions & Socials Zone -->
    <div class="w-full flex flex-col items-center gap-4 mb-2">
        <!-- Show More Info Option Button -->
        <button class="px-6 py-2 border border-zinc-300 hover:border-zinc-800 text-zinc-500 hover:text-zinc-800 text-sm rounded-md transition select-none cursor-pointer">
            Show more info
        </button>

        <!-- Footer Utilities -->
        <div class="flex items-center gap-4 text-zinc-500 mt-1">
            <svg class="w-6 h-6 cursor-pointer hover:text-zinc-800" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M18 5v8a2 2 0 01-2 2h-5l-5 4v-4H4a2 2 0 01-2-2V5a2 2 0 012-2h12a2 2 0 012 2zm-11-1a1 1 0 11-2 0 1 1 0 012 0zM8 9a1 1 0 100-2 1 1 0 000 2zm5-1a1 1 0 11-2 0 1 1 0 012 0z" clip-rule="evenodd" />
            </svg>
            <span class="w-6 h-6 flex items-center justify-center bg-zinc-500 text-white rounded-full font-bold text-xs cursor-pointer hover:bg-zinc-800">f</span>
            <span class="w-6 h-6 flex items-center justify-center bg-zinc-500 text-white rounded-full font-bold text-xs cursor-pointer hover:bg-zinc-800">t</span>
        </div>
    </div>
</div>

<script>
    function speedTest() {
        return {
            isRunning: false,
            displaySpeed: '0.0',
            unit: 'Mbps',
            abortController: null,

            init() {
                // Automatically starts running when page loads, exactly like Fast.com
                this.startTest();
            },

            toggleTest() {
                if (this.isRunning) {
                    this.abortTest();
                } else {
                    this.startTest();
                }
            },

            async startTest() {
                this.isRunning = true;
                this.displaySpeed = '0.0';
                this.abortController = new AbortController();

                const imageAddr = "/speedtest.bin?v=" + new Date().getTime();

                try {
                    const startTime = performance.now();
                    const response = await fetch(imageAddr, {
                        signal: this.abortController.signal
                    });
                    const reader = response.body.getReader();
                    let receivedLength = 0;

                    while (true) {
                        const {
                            done,
                            value
                        } = await reader.read();
                        if (done) break;

                        receivedLength += value.length;
                        let duration = (performance.now() - startTime) / 1000;

                        if (duration > 0) {
                            let bitsLoaded = receivedLength * 8;
                            let speedBps = bitsLoaded / duration;
                            let speedMbps = (speedBps / 1024 / 1024).toFixed(1);

                            // Live update streaming counter onto the UI
                            this.displaySpeed = speedMbps;
                        }
                    }
                } catch (err) {
                    if (err.name !== 'AbortError') {
                        this.displaySpeed = '0.0';
                    }
                } finally {
                    this.isRunning = false;
                }
            },

            abortTest() {
                if (this.abortController) {
                    this.abortController.abort();
                    this.isRunning = false;
                    this.displaySpeed = '0.0';
                }
            }
        }
    }
</script>
