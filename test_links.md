# Test des liens Markdown

Voici un test des différents types de liens supportés par le convertisseur Markdown :

## Liens directs (inline)

Voici un [lien vers Google](https://www.google.com) dans une phrase.

Vous pouvez aussi visiter [GitHub](https://github.com) pour voir du code source.

Pour plus d'informations, consultez [la documentation](https://www.example.com/docs).

## Liens de référence

Voici un [lien de référence][google] et un autre [lien vers GitHub][gh].

Cette phrase contient un [lien vers la documentation][docs] avec une référence.

[google]: https://www.google.com
[gh]: https://github.com
[docs]: https://www.example.com/documentation

## Liens automatiques

Voici une URL automatique : <https://www.apple.com>

Et voici une autre : <https://developer.apple.com/documentation>

## Liens email

Contactez-nous à <support@example.com> pour obtenir de l'aide.

Ou écrivez à <contact@plume-app.com> directement.

## Combinaisons avec d'autres éléments

### Dans des listes

- Visitez [Apple](https://www.apple.com) pour les dernières nouvelles
- Consultez [Stack Overflow](https://stackoverflow.com) pour des questions
- Lisez la [documentation Swift](https://swift.org/documentation)

### Avec emphase

Voici un lien **important** vers [GitHub](https://github.com) à ne pas manquer.

Consultez *absolument* ce [tutoriel](https://www.example.com/tutorial) !

### Liens dans des headers

## Visitez [notre site web](https://www.example.com)

### Pour plus d'infos : [Documentation](https://docs.example.com)

## Test de compatibilité

Les liens fonctionnent avec tous les types de contenus Markdown et s'ouvriront dans un nouvel onglet grâce à l'attribut `target="_blank"`.