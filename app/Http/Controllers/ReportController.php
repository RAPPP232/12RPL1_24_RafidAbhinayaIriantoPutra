<?php

namespace App\Http\Controllers;

use App\Models\Production;
use App\Models\QCInspection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;

class ReportController extends Controller
{
    public function index(Request $request)
    {
        $startDate = $request->input('start_date', now()->startOfMonth()->format('Y-m-d'));
        $endDate = $request->input('end_date', now()->endOfMonth()->format('Y-m-d'));

        $productionReport = Production::with(['part', 'operator', 'qcInspection'])
            ->whereBetween('production_date', [$startDate, $endDate])
            ->get();

        $qcReport = QCInspection::with(['production.part'])
            ->whereHas('production', function($q) use ($startDate, $endDate) {
                $q->whereBetween('production_date', [$startDate, $endDate]);
            })
            ->get();

        $stats = [
            'total_quantity' => $productionReport->sum('quantity'),
            'total_productions' => $productionReport->count(),
            'total_lolos' => $qcReport->where('result', 'lolos')->count(),
            'total_gagal' => $qcReport->where('result', 'gagal')->count(),
            'total_partial' => $qcReport->where('result', 'partial')->count(),
            'percentage_lolos' => $qcReport->count() > 0 ? round(($qcReport->where('result', 'lolos')->count() / $qcReport->count()) * 100, 1) : 0,
        ];

        $partAnalysis = $productionReport->groupBy('part_id')->map(function($items) {
            return [
                'part_name' => $items->first()->part->name,
                'part_code' => $items->first()->part->code,
                'total_quantity' => $items->sum('quantity'),
                'total_productions' => $items->count(),
                'lolos' => $items->filter(function($item) {
                    return $item->qcInspection && $item->qcInspection->result === 'lolos';
                })->count(),
                'partial' => $items->filter(function($item) {
                    return $item->qcInspection && $item->qcInspection->result === 'partial';
                })->count(),
                'gagal' => $items->filter(function($item) {
                    return $item->qcInspection && $item->qcInspection->result === 'gagal';
                })->count(),
            ];
        })->sortByDesc('total_quantity')->values();

        // Group by operator for analysis
        $operatorAnalysis = $productionReport->groupBy('operator_id')->map(function($items) {
            return [
                'operator_name' => $items->first()->operator->name,
                'operator_code' => $items->first()->operator->code,
                'total_quantity' => $items->sum('quantity'),
                'total_productions' => $items->count(),
                'lolos' => $items->filter(function($item) {
                    return $item->qcInspection && $item->qcInspection->result === 'lolos';
                })->count(),
                'partial' => $items->filter(function($item) {
                    return $item->qcInspection && $item->qcInspection->result === 'partial';
                })->count(),
                'gagal' => $items->filter(function($item) {
                    return $item->qcInspection && $item->qcInspection->result === 'gagal';
                })->count(),
            ];
        })->sortByDesc('total_quantity')->values();

        // Damage type analysis
        $damageAnalysis = $qcReport
            ->where('result', 'gagal')
            ->groupBy('damage_type')
            ->map(function($items, $type) {
                return [
                    'type' => str_replace('_', ' ', ucfirst($type)),
                    'count' => $items->count(),
                ];
            })
            ->sortByDesc('count')
            ->values();

        return view('reports.index', compact('productionReport', 'qcReport', 'stats', 'startDate', 'endDate', 'partAnalysis', 'operatorAnalysis', 'damageAnalysis'));
    }

    public function exportPdf(Request $request)
    {
        $startDate = $request->input('start_date', now()->startOfMonth()->format('Y-m-d'));
        $endDate = $request->input('end_date', now()->endOfMonth()->format('Y-m-d'));

        // Get all data (same as index method)
        $productionReport = Production::with(['part', 'operator', 'qcInspection'])
            ->whereBetween('production_date', [$startDate, $endDate])
            ->orderBy('production_date', 'desc')
            ->get();

        $qcReport = QCInspection::with(['production.part'])
            ->whereHas('production', function($q) use ($startDate, $endDate) {
                $q->whereBetween('production_date', [$startDate, $endDate]);
            })
            ->get();

        $stats = [
            'total_quantity' => $productionReport->sum('quantity'),
            'total_productions' => $productionReport->count(),
            'total_lolos' => $qcReport->where('result', 'lolos')->count(),
            'total_partial' => $qcReport->where('result', 'partial')->count(),
            'total_gagal' => $qcReport->where('result', 'gagal')->count(),
            'percentage_lolos' => $qcReport->count() > 0 ? round(($qcReport->where('result', 'lolos')->count() / $qcReport->count()) * 100, 1) : 0,
        ];

        $partAnalysis = $productionReport->groupBy('part_id')->map(function($items) {
            return [
                'part_name' => $items->first()->part->name,
                'part_code' => $items->first()->part->code,
                'total_quantity' => $items->sum('quantity'),
                'total_productions' => $items->count(),
                'lolos' => $items->filter(function($item) {
                    return $item->qcInspection && $item->qcInspection->result === 'lolos';
                })->count(),
                'partial' => $items->filter(function($item) {
                    return $item->qcInspection && $item->qcInspection->result === 'partial';
                })->count(),
                'gagal' => $items->filter(function($item) {
                    return $item->qcInspection && $item->qcInspection->result === 'gagal';
                })->count(),
            ];
        })->sortByDesc('total_quantity')->values();

        $operatorAnalysis = $productionReport->groupBy('operator_id')->map(function($items) {
            return [
                'operator_name' => $items->first()->operator->name,
                'operator_code' => $items->first()->operator->code,
                'total_quantity' => $items->sum('quantity'),
                'total_productions' => $items->count(),
                'lolos' => $items->filter(function($item) {
                    return $item->qcInspection && $item->qcInspection->result === 'lolos';
                })->count(),
                'partial' => $items->filter(function($item) {
                    return $item->qcInspection && $item->qcInspection->result === 'partial';
                })->count(),
                'gagal' => $items->filter(function($item) {
                    return $item->qcInspection && $item->qcInspection->result === 'gagal';
                })->count(),
            ];
        })->sortByDesc('total_quantity')->values();

        $damageAnalysis = $qcReport
            ->filter(function($item) {
                return in_array($item->result, ['gagal', 'partial']);
            })
            ->groupBy('damage_type')
            ->map(function($items, $type) {
                return [
                    'type' => str_replace('_', ' ', ucfirst($type)),
                    'count' => $items->count(),
                ];
            })
            ->sortByDesc('count')
            ->values();

        $data = [
            'productionReport' => $productionReport,
            'qcReport' => $qcReport,
            'stats' => $stats,
            'startDate' => $startDate,
            'endDate' => $endDate,
            'partAnalysis' => $partAnalysis,
            'operatorAnalysis' => $operatorAnalysis,
            'damageAnalysis' => $damageAnalysis,
            'generatedAt' => now()->format('d F Y, H:i'),
            'generatedBy' => auth()->user()->name,
        ];

        $pdf = Pdf::loadView('reports.pdf', $data)
            ->setPaper('a4', 'portrait')
            ->setOptions([
                'isHtml5ParserEnabled' => true,
                'isRemoteEnabled' => true,
                'defaultFont' => 'sans-serif'
            ]);

        $filename = 'Laporan_Produksi_' . Carbon::parse($startDate)->format('d-m-Y') . '_sd_' . Carbon::parse($endDate)->format('d-m-Y') . '.pdf';

        return $pdf->download($filename);
    }
}
