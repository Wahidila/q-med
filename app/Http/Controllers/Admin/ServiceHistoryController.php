<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Service;
use Illuminate\Http\Request;

class ServiceHistoryController extends Controller
{
    public function index(Request $request)
    {
        $date = $request->get('date', now()->toDateString());

        $services = Service::with(['queue.patient'])
            ->whereHas('queue', function ($q) use ($date) {
            $q->where('queue_date', $date);
        })
            ->orderBy('created_at', 'desc')
            ->get();

        $totalRevenue = $services->sum('cost');

        return view('admin.services', compact('services', 'date', 'totalRevenue'));
    }
}
