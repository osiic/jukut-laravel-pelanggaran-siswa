<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Rule;

class DashboardController extends Controller
{
    public function index()
    {
        if (auth()->user()->role !== 'teacher') {
            return redirect()->route('home');
        }

        $users = User::with(['department', 'generation', 'classRoom'])->paginate(5);
        $rules = Rule::all();

        return view('dashboard', compact('users', 'rules'));
    }

    public function show($department, $year, $class)
    {
        if (auth()->user()->role !== 'teacher') {
            return redirect()->route('home');
        }

        $users = User::whereHas('department', fn($q) => $q->where('name', $department))
            ->whereHas('generation', fn($q) => $q->where('year', $year))
            ->whereHas('classRoom', fn($q) => $q->where('name', $class))
            ->paginate(5);

        $rules = Rule::all();

        return view('dashboard', compact('users', 'rules'));
    }
}
