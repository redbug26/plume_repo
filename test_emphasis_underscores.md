# Test de l'emphase avec underscores

Ce fichier teste tous les types d'emphase supportés par le convertisseur Markdown.

## Emphase avec astérisques (déjà supporté)

Voici du texte *en italique* avec des astérisques.

Voici du texte **en gras** avec des astérisques.

Voici du texte ***en gras et italique*** avec des astérisques.

## Emphase avec underscores (nouvellement ajouté)

Voici du texte _en italique_ avec des underscores.

Voici du texte __en gras__ avec des underscores.

Voici du texte ___en gras et italique___ avec des underscores.

## Mélange des deux syntaxes

Vous pouvez mélanger *italique avec astérisques* et _italique avec underscores_.

Vous pouvez mélanger **gras avec astérisques** et __gras avec underscores__.

## Dans d'autres éléments

### Headers avec _emphase_

- Liste avec *astérisques* et _underscores_
- Élément avec **gras astérisques** et __gras underscores__
- Élément avec ***combiné astérisques*** et ___combiné underscores___

### Avec des liens

Visitez [ce site *important*](https://example.com) pour plus d'infos.

Consultez [cette _ressource utile_](https://docs.example.com) également.

## Tests de compatibilité

Le texte peut avoir des_underscores_dans_les_noms de fichiers sans être transformé.

Mais _ceci sera en italique_ car il y a des espaces autour.

De même pour __ceci qui sera en gras__.

## Cas limites

Un seul _ underscore ne fait rien.

Deux underscores __ sans fermeture ne font rien.

Mais __ceci fonctionne__ correctement.

Et _ceci aussi_ fonctionne parfaitement.