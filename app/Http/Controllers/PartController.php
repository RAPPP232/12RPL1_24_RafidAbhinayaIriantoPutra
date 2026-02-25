<?php

namespace App\Http\Controllers;

use App\Models\Part;
use Illuminate\Http\Request;

class PartController extends Controller
{
    public function index()
    {
        $parts = Part::withCount('productions')->latest()->paginate(10);
        return view('parts.index', compact('parts'));
    }

    public function create()
    {
        return view('parts.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'code' => 'required|unique:parts',
            'name' => 'required|max:255',
            'description' => 'nullable',
        ]);

        Part::create($request->all());

        return redirect()->route('parts.index')
            ->with('success', 'Part berhasil ditambahkan');
    }

    public function edit(Part $part)
    {
        return view('parts.edit', compact('part'));
    }

    public function update(Request $request, Part $part)
    {
        $request->validate([
            'code' => 'required|unique:parts,code,' . $part->id,
            'name' => 'required|max:255',
            'description' => 'nullable',
        ]);

        $part->update($request->all());

        return redirect()->route('parts.index')
            ->with('success', 'Part berhasil diupdate');
    }

    public function destroy(Part $part)
    {
        $part->delete();
        return redirect()->route('parts.index')
            ->with('success', 'Part berhasil dihapus');
    }
}
