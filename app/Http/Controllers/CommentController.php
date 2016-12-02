<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;
use Auth;
use App\Formation;
use App\Page;
use App\Comment;

class CommentController extends Controller
{
    public function formation($formationId)
    {
        $formation = Formation::findOrFail($formationId);
        $comments  = $formation->comments()->get();

        return view('forum.topic', ['topic' => $formation, 'comments' => $comments]);
    }

    public function page($formationId, $pageId)
    {
        $page      = Page::findOrFail($pageId);
        $comments  = $page->comments()->get();

        return view('forum.topic', ['topic' => $page, 'comments' => $comments]);
    }

    public function store_formation(Request $request, $formationId)
    {
        $formation = Formation::findOrFail($formationId);

        $validator = Validator::make($request->all(), [
            'comment' => 'required',
        ]);

        if ($validator->fails())
        {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $comment = new Comment;
        $comment->text         = $request->input('comment');
        $comment->user_id      = Auth::user()->id;
        $comment->formation_id = $formationId;
        $comment->save();

        return redirect()->route('formation.forum', [$formationId]);
    }

    public function store_page(Request $request, $formationId, $pageId)
    {
        $page = Page::findOrFail($pageId);

        $validator = Validator::make($request->all(), [
            'comment' => 'required',
        ]);

        if ($validator->fails())
        {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $comment = new Comment;
        $comment->text    = $request->input('comment');
        $comment->user_id = Auth::user()->id;
        $comment->page_id = $pageId;
        $comment->save();

        return redirect()->route('page.forum', [0, $pageId]);
    }
}
