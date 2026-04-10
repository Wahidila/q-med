<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Service;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\StreamedResponse;

class ServiceHistoryController extends Controller
{
    private function buildQuery($date, $filter)
    {
        $query = Service::with(['queue.patient']);
        $parsedDate = Carbon::parse($date);

        $query->whereHas('queue', function ($q) use ($parsedDate, $filter) {
            if ($filter === 'weekly') {
                $q->whereBetween('queue_date', [
                    $parsedDate->copy()->startOfWeek()->toDateString(),
                    $parsedDate->copy()->endOfWeek()->toDateString()
                ]);
            }
            elseif ($filter === 'monthly') {
                $q->whereMonth('queue_date', $parsedDate->month)
                    ->whereYear('queue_date', $parsedDate->year);
            }
            else {
                // daily (default)
                $q->whereDate('queue_date', $parsedDate->toDateString());
            }
        });

        return $query->orderBy('created_at', 'desc');
    }

    public function index(Request $request)
    {
        $date = $request->get('date', now()->toDateString());
        $filter = $request->get('filter', 'daily');

        $services = $this->buildQuery($date, $filter)->get();
        $totalRevenue = $services->sum('cost');

        return view('admin.services', compact('services', 'date', 'filter', 'totalRevenue'));
    }

    public function export(Request $request)
    {
        $date = $request->get('date', now()->toDateString());
        $filter = $request->get('filter', 'daily');

        $services = $this->buildQuery($date, $filter)->get();

        $fileName = "Riwayat_Pelayanan_QMed_{$filter}_{$date}.csv";

        $response = new StreamedResponse(function () use ($services) {
            $handle = fopen('php://output', 'w');

            // Add UTF-8 BOM for proper Excel rendering context
            fprintf($handle, chr(0xEF) . chr(0xBB) . chr(0xBF));

            fputcsv($handle, ['No. Antrian', 'Tanggal', 'Waktu', 'Nama Pasien', 'Hasil Pelayanan', 'Biaya'], ';');

            foreach ($services as $service) {
                fputcsv($handle, [
                    $service->queue->queue_number ?? '-',
                    Carbon::parse($service->queue->queue_date)->format('d/m/Y'),
                    $service->created_at->format('H:i'),
                    $service->queue->patient->name ?? '-',
                    $service->description,
                    $service->cost,
                ], ';');
            }

            fclose($handle);
        });

        $response->headers->set('Content-Type', 'text/csv; charset=utf-8');
        $response->headers->set('Content-Disposition', 'attachment; filename="' . $fileName . '"');

        return $response;
    }
}
