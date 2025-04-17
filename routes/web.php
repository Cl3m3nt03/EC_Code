<?php

use App\Http\Controllers\CohortController;
use App\Http\Controllers\CommonLifeController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RetroController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\KnowledgeController;
use App\Http\Controllers\GroupController;
use App\Http\Controllers\TeacherController;
use App\Http\Controllers\MistralController;
use App\Services\MistralService;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\GroupeController;
use App\Http\Controllers\RetrosDataController;
use App\Http\Controllers\RetrosColumnsController;
use Illuminate\Support\Facades\Broadcast;

// Redirect the root path to /dashboard
Route::redirect('/', 'dashboard');

Route::middleware('auth')->group(function () {

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::middleware('verified')->group(function () {
        // Dashboard
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

        // Cohorts
        Route::get('/cohorts', [CohortController::class, 'index'])->name('cohort.index');
        Route::get('/cohort/{cohort}', [CohortController::class, 'show'])->name('cohort.show');

        // Teachers
        Route::get('/teachers', [TeacherController::class, 'index'])->name('teacher.index');

        // Students
        Route::get('students', [StudentController::class, 'index'])->name('student.index');

        // Knowledge
        Route::get('knowledge', [KnowledgeController::class, 'index'])->name('knowledge.index');

        // Groups
        Route::get('groups', [GroupController::class, 'index'])->name('group.index');

        // Retro
        route::get('retros', [RetroController::class, 'index'])->name('retro.index');

        // Common life
        Route::get('common-life', [CommonLifeController::class, 'index'])->name('common-life.index');

    });
    
});


//groups
Route::group(['middleware' => ['web', 'groups']], function () {
    Route::delete('/groupes/{id}', [GroupeController::class, 'destroy'])->name('groupes.destroy');
    Route::post('/groupes', [GroupeController::class, 'store'])->name('groupes.store');
    Route::get('/groupes/{id}', [GroupeController::class, 'edit'])->name('groupes.edit');
    Route::put('/groupes/{id}', [GroupeController::class, 'update'])->name('groupes.update');
});

// retro
Route::group(['middleware' => ['web']], function(){
    Route::post('/retros', [RetroController::class, 'create'])->name('retros.create');
    Route::get('/retros/{retro}', [RetroController::class, 'show'])->name('retros.show');
    Route::delete('/retros/{retro}', [RetroController::class, 'destroy'])->name('retros.destroy');

    
    Route::post('/retros/{retro}/columns', [RetrosColumnsController::class, 'store'])->name('retros.columns.create');
    Broadcast::channel('retro', function ($user) {
        return true;
    });

    Route::get('/retros/{id}/fetch', [RetroController::class, 'fetch'])->name('retros.fetch');
    Route::post('/retros/data', [RetrosDataController::class, 'store'])->name('retros.data.store');
    Route::put('/retros/data/move', [RetroController::class, 'moveCard'])->name('card.move');    
    Route::put('/retros/data/{retrosData}', [RetrosDataController::class, 'update'])->name('retros.data.update');
    
});

require __DIR__.'/auth.php';