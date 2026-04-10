<?php

namespace App\Livewire;

use App\Models\Queue;
use Livewire\Component;

class KioskDisplay extends Component
{
    public $currentQueue = null;
    public $upcomingQueues = [];
    public $lastCalledId = null;

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

        if ($called) {
            $this->currentQueue = [
                'id' => $called->id,
                'number' => $called->queue_number,
                'name' => $called->patient->name,
                'status' => $called->status,
            ];
            $this->lastCalledId = $called->id;
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

        // Dispatch browser event when a new queue is called
        if ($called && $previousId !== $called->id) {
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
