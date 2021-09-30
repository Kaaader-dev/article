<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ArticlesController extends Controller
{
    protected $articles = [];

    public function __construct()
    {
        $articles = json_decode(file_get_contents(resource_path('data/articles.json')), true);
        $this->articles = $articles['articles'];
    }

    /**
     * Liste des articles
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index()
    {
        return view('articles.index')->with('articles', $this->articles);
    }

    public function show($id)
    {
        $article = $this->articles[$id - 1];
        return view('articles.show', compact('article', 'id'));
    }

    public function navigate($id, $direction = 'right')
    {
        if( $id > 1 && $id < count($this->articles) ) {
            if( $direction === 'right' ) {
                return redirect()->route('articles.show', $id + 1);
            }

            return redirect()->route('articles.show', $id - 1);
        }

        return redirect()->route('articles.index');
    }
}
