<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Queue;
use App\Models\Service;
use Illuminate\Http\Request;

class QueueController extends Controller
{
    public function index()
    {
        $queues = Queue::today()
            ->with('patient')
            ->orderBy('queue_number')
            ->get();

        $currentServing = Queue::today()
            ->whereIn('status', ['called', 'serving'])
            ->with('patient')
            ->first();

        return view('admin.queue', compact('queues', 'currentServing'));
    }

    public function callNext()
    {
        $current = Queue::today()->whereIn('status', ['called'])->first();
        if ($current) {
            $current->update(['status' => 'serving']);
        }

        $next = Queue::today()
            ->waiting()
            ->orderBy('queue_number')
            ->first();

        if (!$next) {
            return redirect()->route('admin.queue.index')
                ->with('info', 'Tidak ada antrian yang menunggu.');
        }

        $next->update([
            'status' => 'called',
            'called_at' => now(),
        ]);

        return redirect()->route('admin.queue.index')
            ->with('success', "Memanggil antrian #{$next->queue_number} - {$next->patient->name}");
    }

    public function startService(Queue $queue)
    {
        $queue->update(['status' => 'serving']);

        return redirect()->route('admin.queue.index')
            ->with('success', "Memulai pelayanan untuk {$queue->patient->name}");
    }

    public function completeService(Request $request, Queue $queue)
    {
        $request->validate([
            'description' => 'required|string',
            'cost' => 'required|numeric|min:0',
        ]);

        Service::create([
            'queue_id' => $queue->id,
            'description' => $request->description,
            'cost' => $request->cost,
        ]);

        $queue->update(['status' => 'done']);

        return redirect()->route('admin.queue.index')
            ->with('success', "Pelayanan untuk {$queue->patient->name} telah selesai.");
    }

    public function skipQueue(Queue $queue)
    {
        $queue->update(['status' => 'done']);

        return redirect()->route('admin.queue.index')
            ->with('info', "Antrian #{$queue->queue_number} dilewati.");
    }

    public function recallQueue(Queue $queue)
    {
        $queue->update([
            'status' => 'called',
            'called_at' => now(),
        ]);

        return redirect()->route('admin.queue.index')
            ->with('success', "Memanggil ulang antrian #{$queue->queue_number} - {$queue->patient->name}");
    }
}
