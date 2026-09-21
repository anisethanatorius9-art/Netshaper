<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\SpeedTestHistory as SpeedTestHistoryModel;

class SpeedTestHistoryView extends Component
{
    public $tests = [];

    #[\Livewire\Attributes\On('speedTestCompleted')]
    public function loadTests()
    {
        $this->tests = SpeedTestHistoryModel::latest()
            ->limit(10)
            ->get();
    }

    public function mount()
    {
        $this->loadTests();
    }

    public function render()
    {
        return view('livewire.speed-test-history-view');
    }
}
