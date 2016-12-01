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

        $validator = Validator::make($request->all(), [
            'text' => 'required',
        ]);

        if ($validator->fails())
        {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $comment = new Comment;
        $comment->text         = $request->input('text');
        $comment->formation_id = $formationId;
        $comment->save();

        redirect()->route('formation.forum', [$formationId]);
    }

    public function store_page(Request $request, $formationId, $pageId)
    {
        $page = Page::findOrFail($pageId);

        $validator = Validator::make($request->all(), [
            'text' => 'required',
        ]);

        if ($validator->fails())
        {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $comment = new Comment;
        $comment->text    = $request->input('text');
        $comment->page_id = $pageId;
        $comment->save();

        redirect()->route('page.forum', [$pageId]);
    }
}
