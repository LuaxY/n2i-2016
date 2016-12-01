<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Formation;
use App\Page;
use App\Comment;

class CommentController extends Controller
{
    public function formation($formationId)
    {
        $formation = Formation::findOrFail($formationId);
        $comments  = $formation->comments()->get();

        return view('forum.topic', ['comments' => $comments]);
    }

    public function page($formationId, $pageId)
    {
        $page      = Page::findOrFail($formationId);
        $comments  = $page->comments()->get();

        return view('forum.topic', ['comments' => $comments]);
    }

    public function store_formation(Request $request, $formationId)
    {
        $formation = Formation::findOrFail($formationId);

        redirect()->route('formation.forum', [$formationId]);
    }

    public function store_page(Request $request, $formationId, $pageId)
    {
        $page = Page::findOrFail($pageId);

        redirect()->route('page.forum', [$pageId]);
    }
}
