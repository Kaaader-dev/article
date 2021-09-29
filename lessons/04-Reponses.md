## Les réponses

Nous avons vu précédemment comment la requête qui arrive est traitée par les routes. Voyons maintenant les réponses que nous pouvons renvoyer au client. Nous allons voir le système des vues de Laravel avec la possibilité de transmettre des paramètres. Nous verrons aussi comment créer des templates avec l’outil Blade.

### Les réponses automatiques

Nous avons déjà construit des réponses lorsque nous avons vu le routage au chapitre précédent mais nous n’avons rien fait de spécial pour cela, juste renvoyé une chaîne de caractères comme réponse. 

Si l'on inspecte une de routes déjà utilisées, nous renvoyons une chaîne de caractère, mais évidemment Laravel en coulisse construit une véritable réponse http.

On se rend compte qu’on a une requête complète avec ses headers mais nous ne pouvons pas intervenir sur ces valeurs. Remarquez au passage qu’on a des cookies, on en reparlera lorsque nous verrons les sessions.

Le content-type indique le type MIME du document retourné, pour que le navigateur sache quoi faire du document en fonction de la nature de son contenu. Par exemple :

- **text/html** : page Html classique
- **text/plain** : simple texte sans mise en forme
- **application/pdf** : fichier pdf
- **application/json** : données au format JSON
- **application/octet-stream** : téléchargement de fichier 

Si on crée cette route : 

```injectablephp
Route::get('json', function() {
    return ['un', 'deux', 'trois', 'quatre'];
});
```

On se rend compte qu'on obtiendra une réponse directement formatée en JSON. En gros, pour retourner du JSON, il vous suffit de retourner un tableau, Laravel fera le reste ;)

### Construire une réponse

Le fonctionnement automatique c’est bien mais des fois on veut imposer des valeurs. Dans ce cas il faut utiliser une classe de Laravel pour construire une réponse. Comme la plupart du temps on a un helper qui nous évite de déclarer la classe en question (en l’occurrence c’est la classe Illuminate\Http\Response qui hérite de celle de Symfony : Symfony\Component\HttpFoundation\Response).

```injectablephp
Route::get('reponse-de-test', function () {
    return response('une réponse', 503)->header('Content-Type', 'text/plain');
});
```

Ici on impose une réponse 503 avec un type MIME text/plain. Libre à vous par la suite de dédinir le protocole que vous souhaitez renvoyer.

En fait vous aurez rarement la nécessité de préciser les headers parce que Laravel s’en charge très bien, mais vous voyez que c’est facile à faire.

On peut aussi ajouter un cookie avec la méthode cookie.

## Les vues

Dans une application réelle vous retournerez rarement la réponse directement à partir d’une route, vous passerez au moins par une vue. Dans sa version la plus simple une vue est un simple fichier avec du code Html :

```html
<!doctype html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Mon super site</title>
</head>
<body>
    <p>Je suis une vue !</p>
</body>
</html>
```

Il vous faudra enregistrer cette vue dans le dossier **resources/views** et lui donner un nom, j'ai décidé de l'appeler first_view.php
Même si vous ne mettez que du code HTML dedans, il faudra obligatoirement oper pour l'extension .php

Vous pouvez désormais appeler cette vue dans vos routes :

```injectablephp
Route::get('ma-premiere-vue', function() {
    return view('first_view');
});
```

### Passer des paramètres à votre vue

En général on a des informations à transmettre à une vue, voyons à présent comment mettre cela en place. Supposons que nous voulions répondre à ce type de requête :

```
http://monsite.fr/article/n
```

Le paramètre n pouvant prendre une valeur numérique . Voyons comment cette url est constituée :

- https://monsite.fr/ : la base de l’url est constante pour le site, quelle que soit la requête,
- article/ : la partie fixe ici correspond aux articles,
- n : la partie variable correspond au numéro de l’article désiré (le paramètre).

Il nous faut donc une route pour intercepter ces urls, par exemple :

```injectablephp
Route::get('article/{n}', function($n) {
    return view('article')->with('numero', $n);
})->whereNumber('n');
```

On transmet la variable à la vue avec la méthode **with**.

Nous aurions également pu faire comme ceci :

```injectablephp
Route::get('article/{n}', function($n) {
    return view('article', [
        'numero'    =>  $n
    ]);
})->whereNumber('n');
```

ou encore :

```injectablephp
Route::get('article/{n}', function($n) {
    return view('article', concat('n'));
})->whereNumber('n');
```

Il ne nous reste plus qu'à créer notre vue **article.php** dans notre dossier **resources/views**