<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 40 40" fill="none" {{ $attributes }}>
    <!-- Red speedometer gauge (semicircle at top) -->
    <path d="M 10 22 A 10 10 0 0 1 30 22" stroke="#ef4444" stroke-width="3" stroke-linecap="round"/>

    <!-- Black WiFi/signal arcs (middle section) -->
    <path d="M 14 26 Q 20 20 26 26" stroke="currentColor" stroke-width="2.2" stroke-linecap="round"/>
    <path d="M 12 29 Q 20 21 28 29" stroke="currentColor" stroke-width="2.2" stroke-linecap="round"/>

    <!-- Black center dot (bottom) -->
    <circle cx="20" cy="34" r="2" fill="currentColor"/>

    <!-- Small speedometer needle indicator (black) -->
    <line x1="20" y1="22" x2="20" y2="16" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
