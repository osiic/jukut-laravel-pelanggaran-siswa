<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ClassRoom;
use App\Models\Department;
use App\Models\Generation;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;

class ClassController extends Controller
{
    /**
     * Display a listing of the classes.
     */
    public function index()
    {
        if (Auth::user()->role !== 'teacher') {
            return Redirect::to('/home');
        }
        $classes = ClassRoom::paginate(5);
        return view('classes.index', compact('classes'));
    }

    /**
     * Show the form for creating a new class.
     */
    public function create()
    {
        if (Auth::user()->role !== 'teacher') {
            return Redirect::to('/home');
        }

        $departments = Department::all();
        $generations = Generation::all();
        return view('classes.create', compact('departments', 'generations'));
    }

    /**
     * Store a newly created class in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'department_id' => 'required|exists:departments,id',
            'generation_id' => 'required|exists:generations,id',
        ]);

        ClassRoom::create($request->all());

        return redirect()->route('classes.index')->with('success', 'Class created successfully.');
    }

    /**
     * Show the form for editing the specified class.
     */
    public function edit(ClassRoom $class)
    {
        if (Auth::user()->role !== 'teacher') {
            return Redirect::to('/home');
        }

        $departments = Department::all();
        $generations = Generation::all();
        return view('classes.edit', compact('class', 'departments', 'generations'));
    }

    /**
     * Update the specified class in storage.
     */
    public function update(Request $request, ClassRoom $class)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'department_id' => 'required|exists:departments,id',
            'generation_id' => 'required|exists:generations,id',
        ]);

        $class->update($request->all());

        return redirect()->route('classes.index')->with('success', 'Class updated successfully.');
    }

    /**
     * Remove the specified class from storage.
     */
    public function destroy(ClassRoom $class)
    {
        $class->delete();
        return redirect()->route('classes.index')->with('success', 'Class deleted successfully.');
    }

    public function getClasses(Request $request)
    {
        $departmentId = $request->department_id;
        $generationId = $request->generation_id;

        $classes = ClassRoom::where('department_id', $departmentId)
                    ->where('generation_id', $generationId)
                    ->get();

        return response()->json($classes);
    }
}
