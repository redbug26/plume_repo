# Test des règles horizontales

Ce fichier teste les différents types de règles horizontales supportées par le convertisseur Markdown.

## Règles avec des tirets

Voici du texte avant la première règle.

---

Et voici du texte après la première règle.

Vous pouvez utiliser plus de trois tirets :

-----

Ou même beaucoup plus :

----------

## Règles avec des astérisques

Voici une règle avec des astérisques :

***

Et une avec plus d'astérisques :

*****

Encore plus d'astérisques :

**********

## Règles avec des underscores

Voici une règle avec des underscores :

___

Et une avec plus d'underscores :

_____

Encore plus d'underscores :

__________

## Règles avec espaces

Les règles peuvent avoir des espaces avant et après :

   ---   

Ou seulement avant :

   ***

Ou seulement après :

___   

## Dans du contenu mixte

### Section 1

Voici du contenu dans la première section.

---

### Section 2

Voici du contenu dans la deuxième section avec une liste :

- Premier élément
- Deuxième élément
- Troisième élément

***

### Section 3

Et voici la dernière section avec du texte **en gras** et _en italique_.

Il y a aussi des [liens](https://example.com) qui fonctionnent.

___

## Fin du test

Les règles horizontales sont maintenant parfaitement supportées dans tous les contextes !