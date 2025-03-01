<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Rule;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::with(['department', 'generation', 'classRoom'])
            ->where('role', 'student') // Hanya ambil user dengan role "student"
            ->orderBy('updated_at', 'desc') // Urutkan berdasarkan yang terbaru diperbarui
            ->paginate(5);

        return view('home', compact('users'));
    }

    /**
     * Filter students based on department, year, and class.
     */
    public function filterStudents($department, $year, $class)
    {
        $users = User::whereHas('department', function ($query) use ($department) {
                $query->where('name', $department);
            })
            ->whereHas('generation', function ($query) use ($year) {
                $query->where('year', $year);
            })
            ->whereHas('classRoom', function ($query) use ($class) {
                $query->where('name', $class);
            })
            ->paginate(5);

        $rules = Rule::all();

        return view('dashboard', compact('users', 'rules'));
    }
}
