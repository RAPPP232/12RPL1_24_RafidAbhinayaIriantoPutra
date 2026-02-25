<?php

namespace App\Http\Controllers;

use App\Models\Production;
use App\Models\Part;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProductionController extends Controller
{
    public function index()
    {
        $query = Production::with(['part', 'operator', 'qcInspection']);
        
        if (auth()->user()->isOperator()) {
            $query->where('operator_id', auth()->id());
        }
        
        $productions = $query->latest()->paginate(15);

        // Calculate total lolos per part
        $totalsPerPart = \App\Models\QCInspection::select(
            'parts.id',
            'parts.name as part_name',
            'parts.code as part_code',
            DB::raw('SUM(qc_inspections.passed_quantity) as total_lolos')
        )
            ->join('productions', 'qc_inspections.production_id', '=', 'productions.id')
            ->join('parts', 'productions.part_id', '=', 'parts.id')
            ->groupBy('parts.id', 'parts.name', 'parts.code')
            ->get();
        
        return view('productions.index', compact('productions', 'totalsPerPart'));
    }

    public function create()
    {
        $parts = Part::all();
        $operators = User::where('role', 'operator')->get();
        return view('productions.create', compact('parts', 'operators'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'part_id' => 'required|exists:parts,id',
            'operator_id' => 'required|exists:users,id',
            'production_date' => 'required|date',
            'quantity' => 'required|integer|min:1',
            'notes' => 'nullable',
        ]);

        Production::create([
            'part_id' => $request->part_id,
            'operator_id' => $request->operator_id,
            'production_date' => $request->production_date,
            'quantity' => $request->quantity,
            'status' => 'in_progress',
            'notes' => $request->notes,
        ]);

        return redirect()->route('productions.index')
            ->with('success', 'Data produksi berhasil ditambahkan');
    }

    public function show(Production $production)
    {
        $production->load(['part', 'operator', 'qcInspection.inspector']);
        return view('productions.show', compact('production'));
    }

    public function updateStatus(Request $request, Production $production)
    {
        $request->validate([
            'status' => 'required|in:pending,in_progress,completed,rejected',
        ]);

        $production->update(['status' => $request->status]);

        return back()->with('success', 'Status produksi berhasil diupdate');
    }
}