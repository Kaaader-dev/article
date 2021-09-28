## Le système de routage

### Rappel

Le HTTP (Hypertext Transfer Protocol) est un protocole de communication entre un client et un serveur. Le client demande une ressource au serveur en envoyant une requête et le serveur réagit en envoyant une réponse, en général une page Html.

Quand on surfe sur Internet chacun de nos clics provoque en général cet échange, et plus généralement une rafale d’échanges.

La requête du client comporte un certain nombre d’informations (headers, status code, body…).

### Les méthodes

- **GET** : c’est la plus courante, on demande une ressource qui ne change jamais, on peut mémoriser la requête, on est sûr d’obtenir toujours la même ressource,
- **POST** : elle est aussi très courante, là la requête modifie ou ajoute une ressource, le cas le plus classique est la soumission d’un formulaire (souvent utilisé à tort à la place de PUT),
- **PUT** : on ajoute ou remplace complètement une ressource,
- **PATCH** : on modifie partiellement une ressource (donc à ne pas confondre avec PUT),
- **DELETE** : on supprime une ressource.