<?php

namespace App\Http\Controllers;

use App\Models\Production;
use App\Models\QCInspection;
use App\Models\Part;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        
        $stats = [
            'total_productions' => Production::count(),
            'total_parts' => Part::count(),
            'total_operators' => User::where('role', 'operator')->count(),
            'pending_inspections' => Production::where('status', 'completed')
                ->whereDoesntHave('qcInspection')->count(),
        ];
        
        if ($user->isOperator()) {
            $recentProductions = Production::where('operator_id', $user->id)
                ->with(['part', 'operator'])
                ->latest()
                ->take(5)
                ->get();
        } else {
            $recentProductions = Production::with(['part', 'operator'])
                ->latest()
                ->take(5)
                ->get();
        }
        
        return view('dashboard', compact('stats', 'recentProductions'));
    }
}