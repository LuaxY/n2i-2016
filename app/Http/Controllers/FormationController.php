<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Collection;
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
        $keywords = explode(' ', $request->input('query'));

        if (!$keywords)
        {
            redirect()->back()->withInput();
        }

        $formations = new Collection;
        $pages      = new Collection;
        $comments   = new Collection;

        foreach ($keywords as $keyword)
        {
            $formations = $formations->merge(Formation::where('title', 'LIKE', "%$keyword%")->orWhere('description', 'LIKE', "%$keyword%")->get());
            $pages      = $pages->merge(Page::where('title', 'LIKE', "%$keyword%")->orWhere('text', 'LIKE', "%$keyword%")->get());
            $comments   = $comments->merge(Comment::where('text', 'LIKE', "%$keyword%")->get());
        }

        //dd($formations, $pages, $comments);

        return view('search', compact($formations, $pages, $comments));
    }
}
