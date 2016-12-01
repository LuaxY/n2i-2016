<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Formation;
use App\Comment;

class FormationController extends Controller
{
    public function list()
    {
        $formations = Formation::all();

        return view('formation.list', ['formations' => $formations]);
    }

    public function view($formationId)
    {
        $formation = Formation::findOrFail($formationId);

        return view('formation.view', ['formation' => $formation]);
    }

    public function forum($formationId)
    {
        $formation = Formation::findOrFail($formationId);
        $comments  = $formation->comments()->get();

        return view('forum.topic', ['comments' => $comments]);
    }
}
