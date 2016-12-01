<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Formation;

class FormationController extends Controller
{
    public function all()
    {
        $formations = Formation::all();

        return view('formation.list', ['formations' => $formations]);
    }

    public function view($formationId)
    {
        $formation = Formation::findOrFail($formationId);

        return view('formation.view', ['formation' => $formation]);
    }
}
