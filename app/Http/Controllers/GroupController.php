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
use App\Http\Controllers\MistralController;



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

        // Récupération des utilisateurs avec la moyenne de toutes les compétences
        $users = DB::table('users')
            ->join('users_schools', 'users.id', '=', 'users_schools.user_id')
            ->join('notes', 'users.id', '=', 'notes.user_id')
            ->where('users_schools.cohort_id', $cohortId)
            ->select('users.id', 'users.first_name', 'users.last_name', DB::raw('AVG(notes.note) as average_note'))
            ->groupBy('users.id', 'users.first_name', 'users.last_name')
            ->orderByDesc('average_note')
            ->get();

        if ($users->isEmpty()) {
            return redirect()->back()->with('error', 'Aucun utilisateur trouvé avec des notes pour cette cohorte.');
        }

        // Construction du prompt
        $prompt = "Voici une liste d'étudiants avec leurs moyennes sur 20 :\n";
        foreach ($users as $user) {
            $fullName = "{$user->first_name} {$user->last_name}";
            $prompt .= "- $fullName : " . round($user->average_note, 2) . "\n";
        }
        $prompt .= "\nForme des groupes de $groupSize étudiants. Chaque groupe doit contenir un mélange d’étudiants forts et moins forts, pour équilibrer les niveaux. Ne regroupe pas uniquement ceux qui ont les meilleures notes ensemble. Renvoie un JSON comme ceci :\n";
        $prompt .= '{ "Groupe 1": ["Alice Dupont", "Bob Martin"], "Groupe 2": ["Charlie Dubois", "Diana Petit"] }';


        // Appel Mistral
        $mistralResponse = MistralController::askMistral($prompt);

        // Extraction du JSON avec regex
        preg_match('/\{.*\}/s', $mistralResponse, $match);

        if (!isset($match[0])) {
            return redirect()->back()->with('error', 'Impossible d’extraire un JSON valide de la réponse de l’IA.');
        }

        $groups = json_decode($match[0], true);

        if (!$groups) {
            return redirect()->back()->with('error', 'Erreur de parsing JSON de la réponse IA.');
        }

        // Création des groupes + associations
        $nomsNonTrouves = [];

        foreach ($groups as $groupName => $names) {
            $groupe = Groupe::create([
                'cohort_id' => $cohortId,
                'name' => $groupName,
            ]);

            $userIds = DB::table('users')
                ->whereIn(DB::raw("CONCAT(first_name, ' ', last_name)"), $names)
                ->pluck('id')
                ->toArray();

            // Vérification des noms non trouvés
            $foundNames = DB::table('users')
                ->whereIn(DB::raw("CONCAT(first_name, ' ', last_name)"), $names)
                ->pluck(DB::raw("CONCAT(first_name, ' ', last_name)"))
                ->toArray();

            $notFound = array_diff($names, $foundNames);
            if (!empty($notFound)) {
                $nomsNonTrouves = array_merge($nomsNonTrouves, $notFound);
            }

            $groupe->users()->attach($userIds);
        }

        if (!empty($nomsNonTrouves)) {
            return redirect()->back()->with('warning', 'Groupes générés mais certains noms n\'ont pas été trouvés : ' . implode(', ', $nomsNonTrouves));
        }

        return redirect()->back()->with('success', 'Groupes générés par l’IA avec succès !');
    }






}
