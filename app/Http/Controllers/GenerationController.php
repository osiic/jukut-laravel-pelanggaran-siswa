<?php

namespace App\Http\Controllers;

use App\Models\Generation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;

class GenerationController extends Controller
{
    public function index()
    {
        if (Auth::user()->role !== 'teacher') {
            return Redirect::to('/home');
        }
        $generations = Generation::paginate(5);
        return view('generations.index', compact('generations'));
    }

    public function create()
    {
        if (Auth::user()->role !== 'teacher') {
            return Redirect::to('/home');
        }
        return view('generations.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'year' => 'required|unique:generations|max:255',
        ]);

        Generation::create($request->all());

        return redirect()->route('generations.index')->with('success', 'Generation created successfully.');
    }

    public function edit(Generation $generation)
    {
        if (Auth::user()->role !== 'teacher') {
            return Redirect::to('/home');
        }
        return view('generations.edit', compact('generation'));
    }

    public function update(Request $request, Generation $generation)
    {
        $request->validate([
            'year' => 'required|max:255|unique:generations,year,' . $generation->id,
        ]);

        $generation->update($request->all());

        return redirect()->route('generations.index')->with('success', 'Generation updated successfully.');
    }

    public function destroy(Generation $generation)
    {
        $generation->delete();
        return redirect()->route('generations.index')->with('success', 'Generation deleted successfully.');
    }
}
