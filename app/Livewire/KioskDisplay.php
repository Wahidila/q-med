<?php

namespace App\Livewire;

use App\Models\Queue;
use Livewire\Component;

class KioskDisplay extends Component
{
    public $currentQueue = null;
    public $upcomingQueues = [];
    public $lastCalledId = null;
    public $lastCalledTimestamp = 0;

    public function mount()
    {
        $this->refreshData();
    }

    public function refreshData()
    {
        $called = Queue::today()
            ->whereIn('status', ['called', 'serving'])
            ->with('patient')
            ->orderBy('called_at', 'desc')
            ->first();

        $previousId = $this->lastCalledId;
        $previousTimestamp = $this->lastCalledTimestamp;

        if ($called) {
            $this->currentQueue = [
                'id' => $called->id,
                'number' => $called->queue_number,
                'name' => $called->patient->name,
                'status' => $called->status,
            ];
            $this->lastCalledId = $called->id;
            $this->lastCalledTimestamp = $called->updated_at->timestamp;
        }
        else {
            $this->currentQueue = null;
        }

        $this->upcomingQueues = Queue::today()
            ->waiting()
            ->with('patient')
            ->orderBy('queue_number')
            ->limit(5)
            ->get()
            ->map(fn($q) => [
        'number' => $q->queue_number,
        'name' => $q->patient->name,
        ])
            ->toArray();

        // Only play sound when status is 'called' (not 'serving')
        $isNewCall = $called && $called->status === 'called'
            && ($previousId !== $called->id || $previousTimestamp !== $this->lastCalledTimestamp);

        if ($isNewCall) {
            $this->dispatch('queue-called', [
                'number' => $called->queue_number,
                'name' => $called->patient->name,
            ]);
        }
    }

    public function render()
    {
        $this->refreshData();
        return view('livewire.kiosk-display');
    }
}
