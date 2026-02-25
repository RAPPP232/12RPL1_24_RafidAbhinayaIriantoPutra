<?php

namespace App\Http\Controllers;

use App\Models\QCInspection;
use App\Models\Production;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class QCInspectionController extends Controller
{
    public function index()
    {
        $inspections = QCInspection::with(['production.part', 'production.operator', 'inspector'])
            ->latest()
            ->paginate(15);
        
        // Calculate totals
        $totalLolos = QCInspection::sum('passed_quantity');
        $totalGagal = QCInspection::sum('failed_quantity');

        // Calculate total lolos per part
        $totalsPerPart = QCInspection::select(
            'parts.id',
            'parts.name as part_name',
            'parts.code as part_code',
            DB::raw('SUM(qc_inspections.passed_quantity) as total_lolos')
        )
            ->join('productions', 'qc_inspections.production_id', '=', 'productions.id')
            ->join('parts', 'productions.part_id', '=', 'parts.id')
            ->groupBy('parts.id', 'parts.name', 'parts.code')
            ->get();
        
        return view('qc_inspections.index', compact('inspections', 'totalLolos', 'totalGagal', 'totalsPerPart'));
    }

    public function create()
    {
        $productions = Production::whereDoesntHave('qcInspection')
            ->with(['part', 'operator'])
            ->get();
        
        return view('qc_inspections.create', compact('productions'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'production_id' => 'required|exists:productions,id',
            'passed_quantity' => 'required|min:0',
            'failed_quantity' => 'required|min:0',
            'damage_type' => 'required_if:failed_quantity,>,0',
            'notes' => 'nullable',
            'recommendation' => 'nullable',
        ]);

        $production = Production::find($request->production_id);
        
        // Validate sum equals production quantity
        if ($request->passed_quantity + $request->failed_quantity != $production->quantity) {
            return back()->withErrors(['passed_quantity' => 'Jumlah lolos + gagal harus sama dengan kuantitas produksi (' . $production->quantity . ')']);
        }

        // Compute result
        if ($request->failed_quantity == 0) {
            $result = 'lolos';
        } elseif ($request->passed_quantity == 0) {
            $result = 'gagal';
        } else {
            $result = 'partial';
        }

        QCInspection::create([
            'production_id' => $request->production_id,
            'inspector_id' => auth()->id(),
            'result' => $result,
            'passed_quantity' => $request->passed_quantity,
            'failed_quantity' => $request->failed_quantity,
            'damage_type' => $request->damage_type,
            'notes' => $request->notes,
            'recommendation' => $request->recommendation,
        ]);

        // Update production status based on result
        $status = ($result === 'lolos') ? 'completed' : (($result === 'gagal') ? 'rejected' : ((int)$request->passed_quantity > (int)$request->failed_quantity ? 'completed' : 'rejected'));
        $production->update(['status' => $status]);

        return redirect()->route('qc-inspections.index')
            ->with('success', 'Hasil inspeksi QC berhasil disimpan');
    }

    public function show(QCInspection $qcInspection)
    {
        $qcInspection->load(['production.part', 'production.operator', 'inspector']);
        return view('qc_inspections.show', compact('qcInspection'));
    }
}