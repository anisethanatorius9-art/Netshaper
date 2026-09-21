<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\Attributes\On;
use App\Models\SpeedTestHistory;
use Illuminate\Support\Facades\Auth;

class SpeedTester extends Component
{
    #[On('saveSpeedResut')]
    public function saveSpeedResult($speed, $ping = 'completed')
    {
        // Save execution results to the database if required
        // SpeedTest::create([
        // 'user_id' => auth()->id() ?? null,
        // 'download_speed' => floatval($speed),
        // 'ping' => intval($ping),
        // ])
    }

    public function render()
    {
        return view('livewire.speed-tester');
    }
}
