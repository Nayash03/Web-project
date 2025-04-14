<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Cohort;

use App\Models\User;
use App\Models\Groupe;


class GroupController extends Controller
{
    /**
     * Display the page
     *
     * @return Factory|View|Application|object
     */
    public function index() {
       //return view('pages.groups.index');
       // Récupère toutes les cohortes depuis la base de données
       $cohorts = Cohort::all();  
       // Passe les cohortes à la vue 'groups.index'
       return view('pages.groups.index', compact('cohorts'));
    }

    public function generate(Request $request)
    {
        $request->validate([
            'cohort_id' => 'required|exists:cohorts,id',
            'group_size' => 'required|integer|min:1',
        ]);
    
        $cohortId = $request->cohort_id;
        $groupSize = $request->group_size;
    
        // Requête avec jointure directe
        $users = DB::table('users')
            ->join('users_schools', 'users.id', '=', 'users_schools.user_id')
            ->where('users_schools.cohort_id', $cohortId)
            ->inRandomOrder()
            ->get();
    
        // Diviser les utilisateurs en groupes
        $chunks = collect($users)->chunk($groupSize);
    
        $i = 1;
        foreach ($chunks as $groupUsers) {
            $groupe = Groupe::create([
                'cohort_id' => $cohortId,
                'name' => "Groupe $i"
            ]);
    
            $userIds = $groupUsers->pluck('id')->toArray();
            $groupe->users()->attach($userIds);
    
            $i++;
        }
    
        return redirect()->back()->with('success', 'Groupes générés avec succès !');
    }



}
