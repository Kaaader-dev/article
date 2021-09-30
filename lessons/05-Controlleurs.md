Pour correctement organiser son code dans une application Laravel il faut bien répartir les tâches. Dans les exemples vus jusqu’à présent j’ai renvoyé une vue à partir d’une route, vous ne ferez pratiquement jamais cela dans une application réelle (même si personne ne vous empêchera de le faire ! ). Les routes sont juste un système d’aiguillage pour trier les requêtes qui arrivent.

_Mais alors qui s’occupe de la suite ?_

Et bien ce sont les contrôleurs, le sujet de ce chapitre.

Nous allons aussi découvrir l’outil Artisan qui est la boîte à outil du développeur pour Laravel.

## Artisan

Lorsqu’on construit une application avec Laravel on a de nombreuses tâches à accomplir, comme par exemple créer des classes, vérifier les routes…

C’est là qu’intervient Artisan, le compagnon indispensable. Il fonctionne en ligne de commande, donc à partir de la console. Il suffit de se positionner dans le dossier racine et d’utiliser la commande :

```
php artisan
```

Et voici ce que vous retourne cette commande :

```
Laravel Framework 8.62.0

Usage:
  command [options] [arguments]

Options:
  -h, --help            Display help for the given command. When no command is given display help for the list command
  -q, --quiet           Do not output any message
  -V, --version         Display this application version
      --ansi|--no-ansi  Force (or disable --no-ansi) ANSI output
  -n, --no-interaction  Do not ask any interactive question
      --env[=ENV]       The environment the command should run under
  -v|vv|vvv, --verbose  Increase the verbosity of messages: 1 for normal output, 2 for more verbose output and 3 for debug

Available commands:
  clear-compiled       Remove the compiled class file
  db                   Start a new database CLI session
  down                 Put the application into maintenance / demo mode
  env                  Display the current framework environment
  help                 Display help for a command
  inspire              Display an inspiring quote
  list                 List commands
  migrate              Run the database migrations
  optimize             Cache the framework bootstrap files
  serve                Serve the application on the PHP development server
  test                 Run the application tests
  tinker               Interact with your application
  up                   Bring the application out of maintenance mode
 auth
  auth:clear-resets    Flush expired password reset tokens
 cache
  cache:clear          Flush the application cache
  cache:forget         Remove an item from the cache
  cache:table          Create a migration for the cache database table
 config
  config:cache         Create a cache file for faster configuration loading
  config:clear         Remove the configuration cache file
 db
  db:seed              Seed the database with records
  db:wipe              Drop all tables, views, and types
 event
  event:cache          Discover and cache the application's events and listeners
  event:clear          Clear all cached events and listeners
  event:generate       Generate the missing events and listeners based on registration
  event:list           List the application's events and listeners
 key
  key:generate         Set the application key
 make
  make:cast            Create a new custom Eloquent cast class
  make:channel         Create a new channel class
  make:command         Create a new Artisan command
  make:component       Create a new view component class
  make:controller      Create a new controller class
  make:event           Create a new event class
  make:exception       Create a new custom exception class
  make:factory         Create a new model factory
  make:job             Create a new job class
  make:listener        Create a new event listener class
  make:mail            Create a new email class
  make:middleware      Create a new middleware class
  make:migration       Create a new migration file
  make:model           Create a new Eloquent model class
  make:notification    Create a new notification class
  make:observer        Create a new observer class
  make:policy          Create a new policy class
  make:provider        Create a new service provider class
  make:request         Create a new form request class
  make:resource        Create a new resource
  make:rule            Create a new validation rule
  make:seeder          Create a new seeder class
  make:test            Create a new test class
 migrate
  migrate:fresh        Drop all tables and re-run all migrations
  migrate:install      Create the migration repository
  migrate:refresh      Reset and re-run all migrations
  migrate:reset        Rollback all database migrations
  migrate:rollback     Rollback the last database migration
  migrate:status       Show the status of each migration
 model
  model:prune          Prune models that are no longer needed
 notifications
  notifications:table  Create a migration for the notifications table
 optimize
  optimize:clear       Remove the cached bootstrap files
 package
  package:discover     Rebuild the cached package manifest
 queue
  queue:batches-table  Create a migration for the batches database table
  queue:clear          Delete all of the jobs from the specified queue
  queue:failed         List all of the failed queue jobs
  queue:failed-table   Create a migration for the failed queue jobs database table
  queue:flush          Flush all of the failed queue jobs
  queue:forget         Delete a failed queue job
  queue:listen         Listen to a given queue
  queue:monitor        Monitor the size of the specified queues
  queue:prune-batches  Prune stale entries from the batches database
  queue:prune-failed   Prune stale entries from the failed jobs table
  queue:restart        Restart queue worker daemons after their current job
  queue:retry          Retry a failed queue job
  queue:retry-batch    Retry the failed jobs for a batch
  queue:table          Create a migration for the queue jobs database table
  queue:work           Start processing jobs on the queue as a daemon
 route
  route:cache          Create a route cache file for faster route registration
  route:clear          Remove the route cache file
  route:list           List all registered routes
 sail
  sail:install         Install Laravel Sail's default Docker Compose file
  sail:publish         Publish the Laravel Sail Docker files
 schedule
  schedule:list        List the scheduled commands
  schedule:run         Run the scheduled commands
  schedule:test        Run a scheduled command
  schedule:work        Start the schedule worker
 schema
  schema:dump          Dump the given database schema
 session
  session:table        Create a migration for the session database table
 storage
  storage:link         Create the symbolic links configured for the application
 stub
  stub:publish         Publish all stubs that are available for customization
 vendor
  vendor:publish       Publish any publishable assets from vendor packages
 view
  view:cache           Compile all of the application's Blade templates
  view:clear           Clear all compiled view files

```

Nous verrons par la suite à quoi servent ces commandes au fur et à mesure que nous les utiliserons.

## Les contrôleurs

La tâche d’un contrôleur est de réceptionner une requête (qui a déjà été sélectionnée par une route) et de définir la réponse appropriée, rien de moins et rien de plus. Voici une illustration du processus :

Pour créer un contrôleur, vous pouvez exécuter la commande suivante :

```
php artisan make:controller LessonsController
```

Et si tout se passe bien, vous devriez trouver une classe LessonController dans le dossier app/Http/Controllers :

```injectablephp
<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LessonsController extends Controller
{
    //
}
```

Nous pouvons aggrémenter notre contrôleur en lui créant une première fonction, que nous nommerons par convention index, comme ceci :

```injectablephp
<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LessonsController extends Controller
{
    public function index()
    {
        return view('lessons');
    }
}
```

Analysons notre code :

Analysons un peu le code :

- on trouve en premier l’espace de nom (App\Http\Controllers),
- le contrôleur hérite de la classe Controller qui se trouve dans le même dossier et qui permet de factoriser des actions communes à tous les contrôleurs,
- on trouve enfin la méthode index qui renvoie quelque chose que maintenant vous connaissez : une vue, en l’occurrence « lessons » dont nous avons déjà parlé. Donc si j’appelle cette méthode je retourne la vue « lessons » au client.

Cette fonction retournera une vue que nous allons créer de ce pas :

```html
<!doctype html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Ma page lessons</title>
</head>
<body>
<p>Nous sommes sur la page Lesson, qui utilise le contrôleur LessonController</p>
</body>
</html>
```

Maintenant, pour rendre notre contrôleur utilisable, nous allons devoir le lier à nos routes. Nous allons donc créer une nouvelle route et la nommer :

```injectablephp
Route::get('lessons', [LessonController::class, 'index'])->name('lessons');
```

Désormais si vous vous rendez sur monsite.fr/lessons vous aurez bien votre page de cours affichée, appelée par vos routes.

## Cas pratique

Maintenant imaginons un cas pratique avec un système d'articles. Je vous fournir un tableau de test contenant une série d'articles :

```injectablephp
[
  'status' => 'ok',
  'totalResults' => 2677,
  'articles' => [
    0 => [
      'source' => [
        'id' => 'engadget',
        'name' => 'Engadget',
      ],
      'author' => 'Valentina Palladino',
      'title' => 'Fitbit Charge 5 review: New look, same tricks',
      'description' => 'Fitbit went back to basics with last year’s Charge 4, reinstating a fitness tracker with onboard GPS into its lineup after many years of leaving that hole unfilled. With the introduction of the $180 Charge 5 this year, the company is trying to modernize its m…',
      'url' => 'https://www.engadget.com/fitbit-charge-5-review-130043489.html',
      'urlToImage' => 'https://s.yimg.com/os/creatr-uploaded-images/2021-09/7aa23d70-1fb4-11ec-ae32-4a7ac16d5232',
      'publishedAt' => '2021-09-29T13:00:43Z',
      'content' => 'Fitbit went back to basics with last years Charge 4, reinstating a fitness tracker with onboard GPS into its lineup after many years of leaving that hole unfilled. With the introduction of the $180 C… [+6979 chars]',
    ],
    1 => [
      'source' => [
        'id' => 'wired',
        'name' => 'Wired',
      ],
      'author' => 'Adam Speight, WIRED UK',
      'title' => 'Why James Bond Doesn’t Use an iPhone',
      'description' => 'The fictional superspy wields Nokia devices in \'No Time To Die.\' It’s an odd choice, but Apple\'s smartphones aren’t ideal, either.',
      'url' => 'https://www.wired.com/story/why-james-bond-doesnt-use-iphone/',
      'urlToImage' => 'https://media.wired.com/photos/61539becce82f4f072e06ccf/191:100/w_1280,c_limit/JamesBond_MCDNOTI_MG016.jpg',
      'publishedAt' => '2021-09-29T13:00:00Z',
      'content' => 'No Time To Die is almost upon us, and scores of James Bond fanatics are eager to see the spy use ingenious gadgets to save the day. But does he actually use the very best tech to get the job done? We… [+3742 chars]',
    ],
    2 => [
      'source' => [
        'id' => 'the-verge',
        'name' => 'The Verge',
      ],
      'author' => 'Jay Peters',
      'title' => 'You can finally rate Apple’s apps on the App Store',
      'description' => 'Apple is now letting users rate and review many of its own apps in the App Store. There are only a few ratings on apps at the moment, but many of Apple’s apps don’t have overwhelmingly positive scores.',
      'url' => 'https://www.theverge.com/2021/9/29/22700805/apple-app-store-built-in-ratings-reviews-stars',
      'urlToImage' => 'https://cdn.vox-cdn.com/thumbor/TW4Pgf11XrHiLVglsTuXYPnZNTg=/0x146:2040x1214/fit-in/1200x630/cdn.vox-cdn.com/uploads/chorus_asset/file/22817752/acastro_210831_1777_0001.jpg',
      'publishedAt' => '2021-09-29T19:15:34Z',
      'content' => 'Time to share your honest feedback about Apple Mail
Illustration by Alex Castro / The Verge
For years, Apple has let you redownload many built-in apps from the App Store that you may have deleted, … [+1342 chars]',
    ],
    3 => [
      'source' => [
        'id' => 'the-verge',
        'name' => 'The Verge',
      ],
      'author' => 'Barbara Krasnoff',
      'title' => 'How to find your lost iPhone — even if it’s off',
      'description' => 'Apple’s Find My app allows you to locate a misplaced (or stolen) phone. With the expansion of Find My to a variety of other objects, especially via Apple’s AirTags, it’s become even more useful. And iOS 15 brings with it the capability to locate your phone ev…',
      'url' => 'https://www.theverge.com/22697218/iphone-apple-ios-15-find-my-how-to',
      'urlToImage' => 'https://cdn.vox-cdn.com/thumbor/TDdMTD4ldJPRtgi9Q0SfinsgEhA=/0x146:2040x1214/fit-in/1200x630/cdn.vox-cdn.com/uploads/chorus_asset/file/22461376/vpavic_4547_20210421_0021.jpg',
      'publishedAt' => '2021-09-29T13:42:15Z',
      'content' => 'Photo by Vjeran Pavic / The Verge

 

 Apple’s Find My app has been a very useful (and reassuring) feature, allowing you to locate a misplaced (or stolen) phone so that you can retrieve it (or conta… [+2467 chars]',
    ],
    4 => [
      'source' => [
        'id' => NULL,
        'name' => 'Blogspot.com',
      ],
      'author' => 'noreply@blogger.com (Unknown)',
      'title' => 'Apple Design Award-winner rhythm game ‘Thumper’ arriving on Apple Arcade on Oct 1',
      'description' => 'The popular high-intensity rhythm game and Apple Design Award-winner, Thumper: Pocket Edition is landing on Apple Arcade this Friday, October 1.more…The post Apple Design Award-winner rhythm game ‘Thumper’ arriving on Apple Arcade on Oct 1 appeared first on 9…',
      'url' => 'https://techncruncher.blogspot.com/2021/09/apple-design-award-winner-rhythm-game.html',
      'urlToImage' => 'https://lh6.googleusercontent.com/proxy/MlTbykoTBkKP-TkCi-cCJnEhk-a_YNV4NCk-07Fu1v009YuN82Ju8h9AssVNAZ7IdizcCzTIesBgGnATY1rqG0RAHdkz7rUw1H6tUizHWdSHw3O-9hVNisVJWfEL0nCIQRJf3g0brojgKu-_XcK745ulZzvD5QJ2pfZ4C8VttOVBxHZTmLqMaOLsci2-4w=w1200-h630-p-k-no-nu',
      'publishedAt' => '2021-09-29T14:35:00Z',
      'content' => 'The popular high-intensity rhythm game and Apple Design Award-winner, Thumper: Pocket Edition is landing on Apple Arcade this Friday, October 1.
more…
The post Apple Design Award-winner rhythm game… [+130 chars]',
    ],
    5 => [
      'source' => [
        'id' => NULL,
        'name' => 'Blogspot.com',
      ],
      'author' => 'noreply@blogger.com (Unknown)',
      'title' => 'Costa Rican banks continue to ready Apple Pay ahead of expected launch',
      'description' => 'It’s been a few months since 9to5Mac began reporting on Costa Rican banks readying the launch of Apple Pay in the country. Now, Banco Promerica just uploaded Apple’s payment system terms and conditions to its web page.more…The post Costa Rican banks continue …',
      'url' => 'https://techncruncher.blogspot.com/2021/09/costa-rican-banks-continue-to-ready.html',
      'urlToImage' => 'https://lh6.googleusercontent.com/proxy/9JUHNNoks6BmoqVqdZFXPv4e1q7MfE3122QW0_LgXw5zyC1OBxea-b6N1vdA8e6l2ps76Jhyd_obeufen60hl58wkF7wx4FFDmYxcOpsV7qHmkPuarAVJH-XiXazL6bfWZD6rTe9nupKrXCdmPLcNkqJico=w1200-h630-p-k-no-nu',
      'publishedAt' => '2021-09-29T13:42:00Z',
      'content' => 'It’s been a few months since 9to5Mac began reporting on Costa Rican banks readying the launch of Apple Pay in the country. Now, Banco Promerica just uploaded Apple’s payment system terms and conditio… [+193 chars]',
    ],
    6 => [
      'source' => [
        'id' => NULL,
        'name' => 'Blogspot.com',
      ],
      'author' => 'noreply@blogger.com (Unknown)',
      'title' => 'Apple reminds developers about changes to subscription payment system in India',
      'description' => 'Apple today notified developers about a change that will impact apps with renewable subscriptions or other recurring transactions in India. Due to a new directive from the Reserve Bank of India, some in-app transactions made with credit and debit cards may be…',
      'url' => 'https://techncruncher.blogspot.com/2021/09/apple-reminds-developers-about-changes.html',
      'urlToImage' => 'https://lh5.googleusercontent.com/proxy/RbImDtn6yi8uQqMkYJxDET9gyELYtg9eYvkv6GvqFET6X1j84Zk4WOiLB8CQsjc4ej5gGrrbc_W7KUSXsLXHFdVYOw-3lPEAXw4iwXwdhiw2RdsclUrXwls6drzc--hXf1FGPMfPbDmT48FsyDOFNMDMJd8B9LAsV72TdQ=w1200-h630-p-k-no-nu',
      'publishedAt' => '2021-09-29T20:35:00Z',
      'content' => 'Apple today notified developers about a change that will impact apps with renewable subscriptions or other recurring transactions in India. Due to a new directive from the Reserve Bank of India, some… [+277 chars]',
    ],
    7 => [
      'source' => [
        'id' => NULL,
        'name' => 'Blogspot.com',
      ],
      'author' => 'noreply@blogger.com (Unknown)',
      'title' => 'iPhone 13 camera parts get priority as Samsung orders fall below expectations',
      'description' => 'Suppliers of iPhone 13 camera parts are giving priority to Apple orders, according to supply-chain reports. Many of them supply components to a wide range of smartphone brands.The report says there are two reasons for Apple getting more of their output …more……',
      'url' => 'https://techncruncher.blogspot.com/2021/09/iphone-13-camera-parts-get-priority-as.html',
      'urlToImage' => 'https://lh4.googleusercontent.com/proxy/vQ3DcC_lknspM-fVKnDGXS1zZv6hPriRzY_bYiFUvpq9ccn2KO-T7eRBjxZL09AYCybKF4K7x8yoc2Ml9xJDtbhIT2UjIrI9kkOCVM5mxbyI1eN_3qFogiXlKZiiIBtuhhlAUD449QehoXAxyA-tivCimwMlVXmT7O9t1D6xhZ-btrcF9hBQCQXlQKDEBEM=w1200-h630-p-k-no-nu',
      'publishedAt' => '2021-09-29T12:37:00Z',
      'content' => 'Suppliers of iPhone 13 camera parts are giving priority to Apple orders, according to supply-chain reports. Many of them supply components to a wide range of smartphone brands.
The report says there… [+238 chars]',
    ],
    8 => [
      'source' => [
        'id' => NULL,
        'name' => 'Blogspot.com',
      ],
      'author' => 'noreply@blogger.com (Unknown)',
      'title' => 'Apple Watch responsible for calling ambulance and contacting girlfriend of motorcyclist hit by van',
      'description' => 'It’s no secret that as fun as motorcycles are, they’re far more dangerous in the event of a collision than a car. Even the most experienced rider faces the risk of someone driving distracted. That’s one of the main reasons I always ride with my Apple Watch an…',
      'url' => 'https://techncruncher.blogspot.com/2021/09/apple-watch-responsible-for-calling.html',
      'urlToImage' => 'https://lh3.googleusercontent.com/proxy/DegSo2SFLKqUEvO4dlq8likYmSNcbeTGYP6isyhmC7tUlJqBF94TYxHw7fQuWcrAZMpJAhHYJrDgdKpfSqFofSTi4oMtxRxjRkTSy4MQYtLBrPX8qeFXJ_fyf6AoJf5izaNeqKsePqGzkvC_-bkXRGsOXDOP-PBIo6E=w1200-h630-p-k-no-nu',
      'publishedAt' => '2021-09-29T16:35:00Z',
      'content' => 'It’s no secret that as fun as motorcycles are, they’re far more dangerous in the event of a collision than a car. Even the most experienced rider faces the risk of someone driving distracted. That’s … [+375 chars]',
    ],
    9 => [
      'source' => [
        'id' => NULL,
        'name' => 'Blogspot.com',
      ],
      'author' => 'noreply@blogger.com (Unknown)',
      'title' => 'Apple now lets you share how much you love or hate built-in apps via App Store reviews',
      'description' => 'For the longest time, the App Store did not allow users to rate or review Apple’s built-in iPhone and iPad apps, like Mail, Music, News, Stocks and Calculator. However, seemingly since the release of iOS 15 earlier this month, Apple has now lifted that restri…',
      'url' => 'https://techncruncher.blogspot.com/2021/09/apple-now-lets-you-share-how-much-you.html',
      'urlToImage' => 'https://lh5.googleusercontent.com/proxy/litg5eqFDDziU-TfVaW1_P3uuqT4ccvW6uvM7vnXfVN7-Sc5Ge-sOru0x8l4yEQ8Ci5ri-9_lLxDnKAjI3kH3FCoEcj91OodRv8PDmm_CUKBh79c5YH29N6F1JajX0qAANOnFszbGGVKiDt5NJj9X3K2y8SXrou_x3crZspub9zASvG-WuU=w1200-h630-p-k-no-nu',
      'publishedAt' => '2021-09-29T17:35:00Z',
      'content' => 'For the longest time, the App Store did not allow users to rate or review Apple’s built-in iPhone and iPad apps, like Mail, Music, News, Stocks and Calculator. However, seemingly since the release of… [+488 chars]',
    ],
    10 => [
      'source' => [
        'id' => NULL,
        'name' => 'Blogspot.com',
      ],
      'author' => 'noreply@blogger.com (Unknown)',
      'title' => '$75M AAPL stock options declared for Tim Cook at end of quarter',
      'description' => 'AAPL stock options have been declared for Tim Cook and five other Apple execs. The SEC filing shows that Cook is in line for more than half a million shares, worth $75M at current value.Four other execs stand to receive shares worth $20M each, while another i…',
      'url' => 'https://techncruncher.blogspot.com/2021/09/75m-aapl-stock-options-declared-for-tim.html',
      'urlToImage' => 'https://lh3.googleusercontent.com/proxy/-MX_uHRQ1qYcaI1iw5yUAWqtxR8WP5fFy8eLA8EKEepaebmM_O8aHifz9WCH6ssHmLdDbHqv5DkR5IQV0LAuwsDjNHnEffp0yuUJHP_LzAT_e9S-tEzQz4p_LR64xZ-T8miiemYf5hj5Q1P9qXbDb5TT-k1bZueAvnQmn_Sh6aJaXL7XhWJq8g0LUSZf9AyfRJvl=w1200-h630-p-k-no-nu',
      'publishedAt' => '2021-09-29T12:08:00Z',
      'content' => 'AAPL stock options have been declared for Tim Cook and five other Apple execs. The SEC filing shows that Cook is in line for more than half a million shares, worth $75M at current value.
Four other … [+251 chars]',
    ],
    11 => [
      'source' => [
        'id' => NULL,
        'name' => 'Blogspot.com',
      ],
      'author' => 'noreply@blogger.com (Unknown)',
      'title' => 'Users complain about Siri no longer being able to send emails or check call history',
      'description' => 'Apple announced a major upgrade to Siri this year with iOS 15, which is now able to process on-device requests without an internet connection. However, it seems that Apple’s virtual assistant has also lost some functionality, as users have been complaining ab…',
      'url' => 'https://techncruncher.blogspot.com/2021/09/users-complain-about-siri-no-longer.html',
      'urlToImage' => 'https://lh3.googleusercontent.com/proxy/00Fo1jtvjGFsgKe2uxuYy5s2RBlkj4Ajf0u6jG6Sm6Ax_S8sZlm_SPe4vVLdWGJ9Z2AWZXvza-f7gwZ-JRqgSJIolZq0ZPjWzgtvBc5qrJ8xyrcBacHHgzGt6yjQ_ttJKjNPrvlxyhSrxx-KBAZf=w1200-h630-p-k-no-nu',
      'publishedAt' => '2021-09-29T23:35:00Z',
      'content' => 'Apple announced a major upgrade to Siri this year with iOS 15, which is now able to process on-device requests without an internet connection. However, it seems that Apple’s virtual assistant has als… [+314 chars]',
    ],
    12 => [
      'source' => [
        'id' => NULL,
        'name' => 'Blogspot.com',
      ],
      'author' => 'noreply@blogger.com (Unknown)',
      'title' => 'Some iPhone 13 and iOS 15 users affected by touch screen responsiveness bugs',
      'description' => 'Apple released iOS 15 and the iPhone 13 to the public last week, and a handful of early bugs have emerged since then. Now, users of the iPhone 13 are taking to Reddit and Twitter to report touch screen responsiveness issues on their new devices. Interestingly…',
      'url' => 'https://techncruncher.blogspot.com/2021/09/some-iphone-13-and-ios-15-users.html',
      'urlToImage' => 'https://lh3.googleusercontent.com/proxy/oi6lcVTZqsrJcScquPcGlHcB4ONG0YGt7XSJxlT4iODUDa2pNmsxH2EPdt6YSRfn9hRcpJhpVWMiD_MQTUdOCIJjnn5e2higNctO-TGQ2F1qarmNPhYj30LdhAPNtlgX2d5QcPVVeITN5YM-igvsF-f-Nd2B-gLu4MIsaNxPeulm4CZCi_kteDZY6JSOjfq_DG1Q72xaq80=w1200-h630-p-k-no-nu',
      'publishedAt' => '2021-09-29T16:35:00Z',
      'content' => 'Apple released iOS 15 and the iPhone 13 to the public last week, and a handful of early bugs have emerged since then. Now, users of the iPhone 13 are taking to Reddit and Twitter to report touch scre… [+326 chars]',
    ],
    13 => [
      'source' => [
        'id' => 'reuters',
        'name' => 'Reuters',
      ],
      'author' => NULL,
      'title' => 'Apple, Google asked to turn in S.Korea compliance plans by mid-October - Reuters',
      'description' => 'Apple <a href="https://www.reuters.com/companies/AAPL.O" target="_blank">(AAPL.O)</a> and Alphabet\'s <a href="https://www.reuters.com/companies/GOOGL.O" target="_blank">(GOOGL.O)</a> Google have been asked to turn in by mid-October compliance plans for a new …',
      'url' => 'https://www.reuters.com/technology/apple-google-asked-turn-skorea-compliance-plans-by-mid-october-2021-09-29/',
      'urlToImage' => 'https://www.reuters.com/resizer/lUQCLWfiFwWqO2ZkHC0wch17COA=/1200x628/smart/filters:quality(80)/cloudfront-us-east-2.images.arcpublishing.com/reuters/77FHA3NCBNJ3PFYNOQ3EQDDADU.jpg',
      'publishedAt' => '2021-09-29T01:33:00Z',
      'content' => 'SEOUL, Sept 29 (Reuters) - Apple (AAPL.O) and Alphabet\'s (GOOGL.O) Google have been asked to turn in by mid-October compliance plans for a new South Korean law that bans major app store operators fro… [+599 chars]',
    ],
    14 => [
      'source' => [
        'id' => 'reuters',
        'name' => 'Reuters',
      ],
      'author' => NULL,
      'title' => 'Hong Kong government to wind up Lai\'s Next Digital media group - Reuters',
      'description' => 'Hong Kong\'s Financial Secretary Paul Chan has presented a petition to the Court of First Instance to wind up Next Digital Ltd <a href="https://www.reuters.com/companies/0282.HK" target="_blank">(0282.HK)</a>(NDL), the media group owned by jailed tycoon Jimmy …',
      'url' => 'https://www.reuters.com/business/media-telecom/hong-kong-govt-wind-up-media-group-next-digital-2021-09-29/',
      'urlToImage' => 'https://www.reuters.com/resizer/85ky1uzQ5GitY5LJ8EmW1u-Yamg=/1200x628/smart/filters:quality(80)/cloudfront-us-east-2.images.arcpublishing.com/reuters/4ZUVXC5WBNOHRDPCYFVORKOLLY.jpg',
      'publishedAt' => '2021-09-29T10:33:00Z',
      'content' => 'The logo of Next Digital Ltd is seen above an Apple Daily sign on the facade of its building in Hong Kong, China May 17, 2021. REUTERS/Lam YikSept 29 (Reuters) - Hong Kong\'s Financial Secretary Paul … [+1314 chars]',
    ],
    15 => [
      'source' => [
        'id' => 'reuters',
        'name' => 'Reuters',
      ],
      'author' => NULL,
      'title' => 'Senate panel to hear from U.S. Justice Dept antitrust nominee Kanter next week - Reuters',
      'description' => 'Jonathan Kanter, President Joe Biden\'s nominee to lead the antitrust division of the Justice Department, will appear for a confirmation hearing next week before the Senate Judiciary Committee, the committee said on its website.',
      'url' => 'https://www.reuters.com/world/us/senate-panel-hear-us-justice-dept-antitrust-nominee-kanter-next-week-2021-09-29/',
      'urlToImage' => 'https://www.reuters.com/pf/resources/images/reuters/reuters-default.png?d=53',
      'publishedAt' => '2021-09-29T21:30:00Z',
      'content' => 'WASHINGTON, Sept 29 (Reuters) - Jonathan Kanter, President Joe Biden\'s nominee to lead the antitrust division of the Justice Department, will appear for a confirmation hearing next week before the Se… [+1699 chars]',
    ],
    16 => [
      'source' => [
        'id' => 'reuters',
        'name' => 'Reuters',
      ],
      'author' => 'Reuters Staff',
      'title' => 'Australia shares hit near four-month low as China production curbs hit miners - Reuters',
      'description' => 'Australian shares hit a near four-month low on Wednesday, as weak commodity prices hammered local mining stocks on fears over production curbs caused by a power crunch in top consumer China.',
      'url' => 'https://www.reuters.com/article/australia-stocks-midday-idUSL4N2QV07N',
      'urlToImage' => 'https://s1.reutersmedia.net/resources_v2/images/rcom-default.png?w=800',
      'publishedAt' => '2021-09-29T01:31:00Z',
      'content' => 'By Reuters Staff
Sept 29 (Reuters) - Australian shares hit a near four-month low on Wednesday, as weak commodity prices hammered local mining stocks on fears over production curbs caused by a power … [+1381 chars]',
    ],
    17 => [
      'source' => [
        'id' => 'reuters',
        'name' => 'Reuters',
      ],
      'author' => 'Devik Jain',
      'title' => 'US STOCKS-Nasdaq futures up 1% as tech stocks rebound - Reuters',
      'description' => 'Nasdaq futures jumped 1% on Wednesday as technology stocks led a rebound after concerns about inflation and rising Treasury yields drove one of Wall Street\'s worst selloff of this year.',
      'url' => 'https://www.reuters.com/article/usa-stocks-idUSKBN2GP12C',
      'urlToImage' => 'https://static.reuters.com/resources/r/?m=02&d=20210929&t=2&i=1576291139&r=LYNXMPEH8S0L5&w=800',
      'publishedAt' => '2021-09-29T10:51:00Z',
      'content' => '(Reuters) - Nasdaq futures jumped 1% on Wednesday as technology stocks led a rebound after concerns about inflation and rising Treasury yields drove one of Wall Streets worst selloff of this year.
F… [+1977 chars]',
    ],
    18 => [
      'source' => [
        'id' => 'reuters',
        'name' => 'Reuters',
      ],
      'author' => NULL,
      'title' => 'Factbox: The 10 working groups under the U.S.- EU Trade & Technology Council - Reuters',
      'description' => 'U.S. and European Union trade and competition officials launched a new forum on Wednesday, joining forces to better compete with China, shield sensitive technologies, boost semiconductor supplies and coordinate regulation of large technology firms.',
      'url' => 'https://www.reuters.com/business/10-working-groups-under-us-eu-trade-technology-council-2021-09-29/',
      'urlToImage' => 'https://www.reuters.com/resizer/qRHFofT6QrTeP07dyhjX4Q6GGLY=/1200x628/smart/filters:quality(80)/cloudfront-us-east-2.images.arcpublishing.com/reuters/OME2XK3G4JK2RAQDPLZ4BXSHGE.jpg',
      'publishedAt' => '2021-09-29T23:25:00Z',
      'content' => 'U.S. Secretary of State Antony Blinken is flanked by Commerce Secretary Gina Raimondo and Trade Representative Katherine Tai as they meet with European Commission Executive Vice Presidents Margrethe … [+2964 chars]',
    ],
    19 => [
      'source' => [
        'id' => 'reuters',
        'name' => 'Reuters',
      ],
      'author' => NULL,
      'title' => 'Nasdaq futures up 1% as tech stocks rebound - Reuters',
      'description' => 'Nasdaq futures jumped 1% on Wednesday as technology stocks led a rebound after concerns about inflation and rising Treasury yields drove one of Wall Street\'s worst selloff of this year.',
      'url' => 'https://www.reuters.com/business/nasdaq-futures-up-1-tech-stocks-rebound-2021-09-29/',
      'urlToImage' => 'https://www.reuters.com/resizer/TYKUetlkB_aAZ8uD4ry-6Uo81-Y=/1200x628/smart/filters:quality(80)/cloudfront-us-east-2.images.arcpublishing.com/reuters/FDBVW2JBH5OWNKDOFBDDHUTX5M.jpg',
      'publishedAt' => '2021-09-29T10:53:00Z',
      'content' => 'A Wall Street sign is pictured outside the New York Stock Exchange in New York, October 28, 2013. REUTERS/Carlo AllegriSept 29 (Reuters) - Nasdaq futures jumped 1% on Wednesday as technology stocks l… [+2227 chars]',
    ],
  ],
];
```