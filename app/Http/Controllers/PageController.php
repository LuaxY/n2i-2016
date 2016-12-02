<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Formation;
use App\Page;

class PageController extends Controller
{
    public function view($formationId, $pageId)
    {
        $page      = Page::findOrFail($pageId);

        return view('page.view', ['page' => $page]);
    }
}
