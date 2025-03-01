<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Department;
use App\Models\Generation;
use App\Models\ClassRoom;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class UserController extends Controller
{
    /**
     * Display a listing of the users.
     */
    public function index()
    {
        if (Auth::user()->role !== 'teacher') {
            return Redirect::to('/home');
        }
        $users = User::with(['department', 'generation', 'classRoom'])->paginate(5);
        return view('users.index', compact('users'));
    }

    /**
     * Show the form for creating a new user.
     */
    public function create()
    {
        if (Auth::user()->role !== 'teacher') {
            return Redirect::to('/home');
        }
        $departments = Department::all();
        $generations = Generation::all();
        $classes = ClassRoom::all();
        return view('users.create', compact('departments', 'generations', 'classes'));
    }

    /**
     * Store a newly created user in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'role' => 'required|string',
            'password' => 'required|string|min:6|confirmed',
            'department_id' => 'nullable|exists:departments,id',
            'generation_id' => 'nullable|exists:generations,id',
            'class_id' => 'nullable|exists:classes,id',
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'role' => $request->role,
            'password' => Hash::make($request->password),
            'department_id' => $request->department_id,
            'generation_id' => $request->generation_id,
            'class_id' => $request->class_id,
        ]);

        return redirect()->route('users.index')->with('success', 'User created successfully.');
    }

    /**
     * Show the form for editing the specified user.
     */
    public function edit(User $user)
    {
        if (Auth::user()->role !== 'teacher') {
            return Redirect::to('/home');
        }
        $departments = Department::all();
        $generations = Generation::all();
        $classes = ClassRoom::all();
        return view('users.edit', compact('user', 'departments', 'generations', 'classes'));
    }

    /**
     * Update the specified user in storage.
     */
    public function update(Request $request, User $user)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'role' => 'required|string',
            'department_id' => 'nullable|exists:departments,id',
            'generation_id' => 'nullable|exists:generations,id',
            'class_id' => 'nullable|exists:classes,id',
        ]);

        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'role' => $request->role,
            'department_id' => $request->department_id,
            'generation_id' => $request->generation_id,
            'class_id' => $request->class_id,
        ]);

        return redirect()->route('users.index')->with('success', 'User updated successfully.');
    }

    /**
     * Remove the specified user from storage.
     */
    public function destroy(User $user)
    {
        $user->delete();
        return redirect()->route('users.index')->with('success', 'User deleted successfully.');
    }

    public function show($id)
    {
        $user = User::with(['department', 'generation', 'classRoom', 'violations.rule'])->findOrFail($id);
        return response()->json($user);
    }
}
