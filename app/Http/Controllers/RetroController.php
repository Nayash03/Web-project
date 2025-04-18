<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Http\Request;
use App\Models\Cohort;
use App\Models\Retrospective;
use App\Models\RetroColumn;
use App\Models\User;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;



class RetroController extends Controller
{
    /**
     * Display the page
     *
     * @return Factory|View|Application|object
     */

    use AuthorizesRequests;

    public function index() {

        if (!auth()->user()->hasAdminRole()) {
            
            $user = auth()->user()->load('userSchools.cohort.retrospective');
            
            $retro = collect($user->userSchools)
                ->map(fn($us) => $us->cohort?->retrospective)
                ->filter()
                ->first();

            if ($retro) {
                return redirect()->route('retro.show', ['retrospective' => $retro->id]);
            } 
        }
        

        return view('pages.retros.index');
    }

    /**
     * Show the form to create a new retrospective.
     * Only accessible to admins.
     */
    public function create()
    {
        if (!auth()->user()->hasAdminRole()) {
            return redirect()->route('dashboard')->with('error', 'Seuls les admins peuvent créer une rétrospective.');
        }

        $cohorts = Cohort::all();
        return view('pages.retros.create', compact('cohorts'));
    }

    /**
     * Store a new retrospective and its columns in the database.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'cohort_id' => 'required|exists:cohorts,id',
            'columns' => 'required|array|min:1',
            'columns.*' => 'required|string|max:255',
        ]);

        $retrospective = Retrospective::create([
            'title' => $request->title,
            'cohort_id' => $request->cohort_id,
        ]);

        foreach ($request->columns as $index => $columnTitle) {
            RetroColumn::create([
                'title' => $columnTitle,
                'retrospective_id' => $retrospective->id,
                'position' => $index,
            ]);
        }

        return redirect()->route('retro.show', $retrospective->id);
    }


    /**
     * Show a specific retrospective by ID with all its columns and cards.
     * Access is restricted to admins, teachers, or members of the cohort.
     */
    public function show($id)
    {
        $retro = \App\Models\Retrospective::with('columns.cards')->findOrFail($id);

        $user = auth()->user();
        $userCohortIds = $user->userSchools->pluck('cohort.id')->filter()->unique();

        if (!auth()->user()->hasAdminRole()) {
            if (!auth()->user()->hasTeacherRole()) {
                if (!$userCohortIds->contains($retro->cohort_id)) {
                    return redirect()->route('dashboard')->with('error', 'Accès non autorisé à cette rétrospective.');
                }
            }
        }
        return view('pages.retros.show', compact('retro'));
    }





}
