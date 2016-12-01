<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Formation;
use App\Page;
use App\Comment;

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

    public function search(Request $request)
    {
        $keywords = $request->input('query');

        if (!$keywords)
        {
            redirect()->back()->withInput();
        }

        foreach ($keywords as $keyword)
        {
            $formations = Formation::where('title', 'LIKE', "%keyworkd%")->orWhere('discription', 'LIKE', "%keyworkd%")->get();
            $pages      = Page::where('title', 'LIKE', "%keyworkd%")->orWhere('text', 'LIKE', "%keyworkd%")->get();
            $comments   = Comment::where('text', 'LIKE', "%keyworkd%")->get();
        }

        dd($formations);

    }
}
