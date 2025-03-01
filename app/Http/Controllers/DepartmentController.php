<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Department;
use App\Models\Generation;
use App\Models\ClassRoom;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;

class DepartmentController extends Controller
{
    public function index()
    {
        if (Auth::user()->role !== 'teacher') {
            return Redirect::to('/home');
        }
        $departments = Department::paginate(5);
        return view('departments.index', compact('departments'));
    }

    public function create()
    {
        if (Auth::user()->role !== 'teacher') {
            return Redirect::to('/home');
        }
        return view('departments.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:departments|max:255'
        ]);

        Department::create(['name' => $request->name]);

        return redirect()->route('departments.index')->with('success', 'Department berhasil ditambahkan');
    }

    public function edit(Department $department)
    {
        if (Auth::user()->role !== 'teacher') {
            return Redirect::to('/home');
        }
        return view('departments.edit', compact('department'));
    }

    public function update(Request $request, Department $department)
    {
        $request->validate([
            'name' => 'required|unique:departments,name,' . $department->id . '|max:255'
        ]);

        $department->update(['name' => $request->name]);

        return redirect()->route('departments.index')->with('success', 'Department berhasil diperbarui');
    }

    public function destroy(Department $department)
    {
        $department->delete();
        return redirect()->route('departments.index')->with('success', 'Department berhasil dihapus');
    }
    public function list()
    {
    $departments = Department::all();
    $generations = Generation::all();
    $classes = ClassRoom::all();

    return response()->json([$departments, $generations, $classes]);
    }
}
