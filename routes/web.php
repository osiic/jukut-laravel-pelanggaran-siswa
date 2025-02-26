<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\GenerationController;
use App\Http\Controllers\ClassController;
use App\Http\Controllers\ViolationController;
use App\Http\Controllers\RuleController;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Department;
use App\Models\Generation;
use App\Models\ClassRoom;
use App\Models\Violation;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/users/{id}/violations', function ($id) {
    $violations = Violation::where('user_id', $id)
        ->with('rule') // Menyertakan data rule
        ->get();

    return response()->json($violations);
});

Route::get('/users/{id}/details', function ($id) {
    $user = User::with([
        'department',
        'generation',
        'classRoom',
        'violations.rule' // Ambil pelanggaran beserta aturan terkait
    ])->findOrFail($id);

    return response()->json($user);
});

Route::get('/departments/list', function () {
    $departments = Department::all();
    $generations = Generation::all();
    $classes = ClassRoom::all();

    return response()->json([$departments, $generations, $classes]);
});

Route::get('/dashboard/{department}/{year}/{class}', function ($department, $year, $class) {
    $users = User::whereHas('department', function ($query) use ($department) {
            $query->where('name', $department);
        })
        ->whereHas('generation', function ($query) use ($year) {
            $query->where('year', $year);
        })
        ->whereHas('classRoom', function ($query) use ($class) {
            $query->where('name', $class);
        })
        ->get();
    return view('dashboard', compact('users'));
})->middleware(['auth', 'verified'])->name('dashboard.show');

Route::resource('/rules', RuleController::class)->middleware(['auth', 'verified'])->names([
    'index'   => 'rules.index',
    'create'  => 'rules.create',
    'store'   => 'rules.store',
    'show'    => 'rules.show',
    'edit'    => 'rules.edit',
    'update'  => 'rules.update',
    'destroy' => 'rules.destroy',
]);

Route::resource('/violations', ViolationController::class)->middleware(['auth', 'verified'])->names([
    'index'   => 'violations.index',
    'create'  => 'violations.create',
    'store'   => 'violations.store',
    'show'    => 'violations.show',
    'edit'    => 'violations.edit',
    'update'  => 'violations.update',
    'destroy' => 'violations.destroy',
]);

Route::resource('/classes', ClassController::class)->middleware(['auth', 'verified'])->names([
    'index'   => 'classes.index',
    'create'  => 'classes.create',
    'store'   => 'classes.store',
    'show'    => 'classes.show',
    'edit'    => 'classes.edit',
    'update'  => 'classes.update',
    'destroy' => 'classes.destroy',
]);

Route::resource('/generations', GenerationController::class)->middleware(['auth', 'verified'])->names([
    'index'   => 'generations.index',
    'create'  => 'generations.create',
    'store'   => 'generations.store',
    'show'    => 'generations.show',
    'edit'    => 'generations.edit',
    'update'  => 'generations.update',
    'destroy' => 'generations.destroy',
]);

Route::resource('/departments', DepartmentController::class)->middleware(['auth', 'verified'])->names([
    'index'   => 'departments.index',
    'create'  => 'departments.create',
    'store'   => 'departments.store',
    'show'    => 'departments.show',
    'edit'    => 'departments.edit',
    'update'  => 'departments.update',
    'destroy' => 'departments.destroy',
]);

Route::resource('/users', UserController::class)->middleware(['auth', 'verified'])->names([
    'index'   => 'users.index',
    'create'  => 'users.create',
    'store'   => 'users.store',
    'show'    => 'users.show',
    'edit'    => 'users.edit',
    'update'  => 'users.update',
    'destroy' => 'users.destroy',
]);

Route::get('/dashboard', function () {
    if (Auth::user()->role !== 'teacher') {
        return redirect('/home');
    }

    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::get('/home', [HomeController::class, 'index'])->middleware(['auth', 'verified'])->name('home');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

});

require __DIR__.'/auth.php';
