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
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MistralController;
use App\Http\Controllers\RetroCardController;

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
        Route::post('/groups/generate', [GroupController::class, 'generate'])->name('group.generate');


        // Retro
        route::get('retros', [RetroController::class, 'index'])->name('retro.index');

        

        // Affichage de la page de création
        Route::get('retros/create', [RetroController::class, 'create'])->name('retro.create');

        // Soumission du formulaire
        Route::post('retros', [RetroController::class, 'store'])->name('retro.store');

        // Affichage du Kanban d’une rétro
        Route::get('retros/{retrospective}', [RetroController::class, 'show'])->name('retro.show');

        

       

        Route::post('/retros/{retro}/columns/{column}/cards', [RetroCardController::class, 'store'])->name('cards.store');
        Route::post('/cards/{card}/move', [RetroCardController::class, 'move'])->name('cards.move');




        // Common life
        Route::get('common-life', [CommonLifeController::class, 'index'])->name('common-life.index');

        Route::view('/mistral', 'pages.mistral.form'); // Modifier pour correspondre au dossier "pages/mistral"
        Route::post('/mistral/ask', [MistralController::class, 'ask'])->name('mistral.ask');

    });

});

require __DIR__.'/auth.php';
