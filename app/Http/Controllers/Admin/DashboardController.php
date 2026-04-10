<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Queue;
use App\Models\Service;

class DashboardController extends Controller
{
    public function index()
    {
        $today = now()->toDateString();

        $stats = [
            'patients_today' => Queue::today()->count(),
            'waiting' => Queue::today()->waiting()->count(),
            'serving' => Queue::today()->where('status', 'serving')->count(),
            'done' => Queue::today()->where('status', 'done')->count(),
            'revenue_today' => Service::whereHas('queue', fn($q) => $q->where('queue_date', $today))->sum('cost'),
        ];

        $recentQueues = Queue::today()
            ->with('patient')
            ->orderBy('queue_number')
            ->limit(10)
            ->get();

        return view('admin.dashboard', compact('stats', 'recentQueues'));
    }
}
