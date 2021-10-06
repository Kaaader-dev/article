<?php

namespace App\Console\Commands;

use App\Models\Article;
use App\Models\Category;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Console\Command;

class jsonArticle extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:jsonArticle';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Hydrate des models Articles a partir de données Json';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $articlesJson = json_decode(file_get_contents(resource_path('data/articles.json')), true);
        $articlesJson = $articlesJson['articles'];
        foreach($articlesJson as $row) {
            //créer le User si il est pas deja present
            $name = $row['author'];
            if($name == null){
               $name = Str::random(6);
            }
            $user = User::firstOrCreate(
                ['email' => Str::slug($row['author']) . '@gmail.com'],
                [
                    'name' => $name,
                    'password'=> bcrypt(Str::random(10))
                ]
            );
            //Création d'articles
            $article = new Article();
            $article->title = $row['title'];
            $article->slug  = $row['url'];
            $article->description = Str::limit($row['description'], 128);
            $article->content = $row['content'];
            $article->user_id = $user->id;
            $article->urlToImage = $row['urlToImage'];
            $article->save();
            //création de catégorie
            $category = new Category();
            $category->name = $row['source']['name'];
            $category->slug = $row['url'];
            $category->save();

            $article->categories()->attach($category->id);
        }
        return print('OK');
    }
}
