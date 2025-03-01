<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Rule;

class RuleController extends Controller
{
    /**
     * Menampilkan daftar aturan.
     */
    public function index()
    {
        $rules = Rule::paginate(5);
        return view('rules.index', compact('rules'));
    }

    /**
     * Menampilkan form untuk menambah aturan baru.
     */
    public function create()
    {
        return view('rules.create');
    }

    /**
     * Menyimpan aturan baru ke database.
     */
    public function store(Request $request)
    {
        $request->validate([
            'rule' => 'required|string|max:255',
            'points' => 'required|integer|min:1',
        ]);

        Rule::create($request->all());

        return redirect()->route('rules.index')->with('success', 'Rule added successfully.');
    }

    /**
     * Menampilkan form edit aturan.
     */
    public function edit(Rule $rule)
    {
        return view('rules.edit', compact('rule'));
    }

    /**
     * Menyimpan perubahan aturan.
     */
    public function update(Request $request, Rule $rule)
    {
        $request->validate([
            'rule' => 'required|string|max:255',
            'points' => 'required|integer|min:1',
        ]);

        $rule->update($request->all());

        return redirect()->route('rules.index')->with('success', 'Rule updated successfully.');
    }

    /**
     * Menghapus aturan.
     */
    public function destroy(Rule $rule)
    {
        $rule->delete();
        return redirect()->route('rules.index')->with('success', 'Rule deleted successfully.');
    }
}

