<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Process;

class NetworkController extends Component
{
    public bool $isThrottled = false;
    public int $downloadLimit = 25;
    public string $selectedProfile = 'Standard';

    public function applyNetworkSettings()
    {
        if ($this->isThrottled) {
            // Example OS execution command:
            // Process::run("sudo tc qdisc change dev eth0 root tbf rate {$this->downloadLimit}mbit burst 32k lat 400ms");

            $this->js("Flux.toast({ variant: 'warning', heading: 'Throttling Active', text: 'Internet speed capped at ' + \$wire.downloadLimit + ' Mbps.' })");
        } else {
            // Process::run("sudo tc qdisc del dev eth0 root");

            $this->js("Flux.toast({ variant: 'success', heading: 'Restrictions Cleared', text: 'Internet running at full speed!' })");
        }
    }

    public function render()
    {
        return view('livewire.network-controller');
    }
}
