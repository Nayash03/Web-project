<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Http\Request;
use App\Models\Cohort;
use App\Models\Retrospective;
use App\Models\RetroColumn;



class RetroController extends Controller
{
    /**
     * Display the page
     *
     * @return Factory|View|Application|object
     */
    public function index() {
        return view('pages.retros.index');
    }

    public function create()
    {
        $cohorts = Cohort::all();
        return view('pages.retros.create', compact('cohorts'));
    }

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



    public function show($id)
        {
            $retro = \App\Models\Retrospective::with('columns.cards')->findOrFail($id);

            return view('pages.retros.show', compact('retro'));
        }




}
