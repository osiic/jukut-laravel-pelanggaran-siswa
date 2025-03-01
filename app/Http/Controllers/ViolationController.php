<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Violation;
use App\Models\User;
use App\Models\Rule;

class ViolationController extends Controller
{
    public function index()
    {
        $violations = Violation::with(['student', 'teacher', 'rule'])->paginate(5);
        return view('violations.index', compact('violations'));
    }

    public function create()
    {
        $students = User::where('role', 'student')->get();
        $teachers = User::where('role', 'teacher')->get();
        $rules = Rule::all();
        return view('violations.create', compact('students', 'teachers', 'rules'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'teacher_id' => 'required|exists:users,id',
            'rule_id' => 'required|exists:rules,id',
            'reason' => 'nullable|string',
            'punishment' => 'nullable|string',
        ]);

        Violation::create($request->all());

        return redirect()->route('violations.index')->with('success', 'Violation created successfully.');
    }

    public function edit(Violation $violation)
    {
        $students = User::where('role', 'student')->get();
        $teachers = User::where('role', 'teacher')->get();
        $rules = Rule::all();
        return view('violations.edit', compact('violation', 'students', 'teachers', 'rules'));
    }

    public function update(Request $request, Violation $violation)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'teacher_id' => 'required|exists:users,id',
            'rule_id' => 'required|exists:rules,id',
            'reason' => 'nullable|string',
            'punishment' => 'nullable|string',
        ]);

        $violation->update($request->all());

        return redirect()->route('violations.index')->with('success', 'Violation updated successfully.');
    }

    public function destroy(Violation $violation)
    {
        $violation->delete();
        return redirect()->route('violations.index')->with('success', 'Violation deleted successfully.');
    }
}
