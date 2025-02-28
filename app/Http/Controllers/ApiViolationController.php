<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Violation;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class ApiViolationController extends Controller
{
    public function index($id)
    {
        $violations = Violation::where('user_id', $id)->with('rule')->get();
        return response()->json($violations);
    }

    public function store(Request $request, $id)
    {
        $validated = $request->validate([
            'rule_id' => 'required',
            'reason' => 'required|string',
            'punishment' => 'required|string',
        ]);

        $violation = Violation::create([
            'user_id' => $id,
            'teacher_id' => Auth::id(),
            'rule_id' => $validated['rule_id'],
            'reason' => $validated['reason'],
            'punishment' => $validated['punishment'],
        ]);

        return response()->json($violation, 201);
    }

    public function destroy($id)
    {
        $violation = Violation::findOrFail($id);
        $violation->delete();
        return response()->json(['message' => 'Violation deleted successfully']);
    }
}
