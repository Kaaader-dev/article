<?php
namespace App\Http\Controllers;

use App\Http\Requests\SearchForm;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\Article;
use App\Models\User;
use App\Models\Category;

/**
 * Class ArticlesController
 * @package App\Http\Controllers
 */
class ArticlesController extends Controller
{
    protected $articles = [];

    /**
     * ArticlesController constructor.
     */
    public function __construct()
    {
        //  On récupère nos articles dans le fichier JSON fourni
        // $articles = json_decode(file_get_contents(resource_path('data/articles.json')), true);
        //on récupère les données de la BDD
        $articles = Article::all();
        $this->articles = $articles;
    }

    /**
     * Liste des articles
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index()
    {
        // dd($this->articles);
        return view('articles.index')->with('articles', $this->articles);
    }

    /**
     * Vue d'un article
     *
     * @param int $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function show(int $id)
    {
        abort_if($id < 1 || $id > count($this->articles), 404);

        //  On récupère notre article, avec la bonne clé de tableau
        $article = $this->articles[$id - 1];
        return view('articles.show', compact('article', 'id'));
    }

    /**
     * Fonction permettant de naviguer d'article en article
     *
     * @param int $id
     * @param string $direction
     * @return \Illuminate\Http\RedirectResponse
     */
    public function navigate(int $id, string $direction = 'right')
    {
        //  On vérifie que l'identifiant renseigné est supérieur à 1 et inférieur au total du nombre d'article
        if( $id > 1 && $id < count($this->articles) ) {
            if( $direction === 'right' ) {
                //  Direction vers la droite, on incrémente l'id
                return redirect()->route('articles.show', $id + 1);
            }

            //  Direction vers la gauche, on décrémente
            return redirect()->route('articles.show', $id - 1);
        }

        //  Dans le cas contraire on redirige sur l'accueil des articles
        return redirect()->route('articles.index');
    }

    /**
     * Recherche des articles
     *
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     * @throws \Illuminate\Validation\ValidationException
     */
    public function search(SearchForm $request)
    {
        //  Validation du formulaire de recherche
        /*
        $this->validate($request, [
            'search'    =>  ['required', 'min:4', 'max:10'] // On vérifie que le champ "search" est bien rempli
        ]);
        */

        //  On utilise l'outil de collection de laravel pour pouvoir trier nos articles
        $articles = collect($this->articles);

        //  On applique un filtre pour trouver les articles dont le titre contient le mot clé recherché
        $results = $articles->filter(function($article) use($request) {
            return preg_match('/' . strtolower($request->input('search')) . '/', strtolower($article['title']));
        });

        //  On retourne une vue avec nos résultats
        return view('articles.index')->with('articles', $results->all());
    }
    public function create()
    {
        $users = User::all();
        $category = Category::all();
        return view('articles.article-form', [
            'users' => $users,
            'categories' => $category
        ]);
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // dd($request->category_id);
        $request->validate([
            'titre' => 'required|string|max:255',
            'description' => 'required|string|max:255',
            'contenue' => 'required|string|max:255',
            'UrlImage' => 'required|string|max:255',
        ]);

        $article = Article::create([
            'title' => $request->titre,
            'description' => $request->description,
            'content' => $request->contenue,
            'user_id' => $request->user_id,
            'urlToImage' => $request->UrlImage,
            'slug' => 'default',
        ]);
        $article->categories()->attach($request->category_id);

        return redirect('/articles');
    }
}
