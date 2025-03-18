Enhance this prompt to be more detailled and accurate: 

/* ============================================================ */

separate any business logic in a service class to keep the controller thin and clean (only manage HTTP request and validation rules) 

/* ============================================================ */

Given this context:

```
Une course à pied par équipe “ULTIMATE TEAM RACE” est organisée sur 2 jours et on
voudrait mettre en place une application web pour gérer le déroulement et le résultat.
Une course est constituée de plusieurs étapes.
Chaque équipe dispose de plusieurs coureurs qu’elle peut utiliser pour chaque étape.
On doit mettre le même nombre de coureur pour chaque étape.
Ex:
    ● pour l’étape 1 de Betsizaraina,
    ○ l’équipe A a mis Lova et Sabrina
    ○ l’équipe B a mis Justin et Vero
    ○ l’équipe C a mis John et Jill
    ○ etc…
    ● pour l’étape 3 d’Ampasimbe,
    ○ l’équipe A a mis Victor
    ○ l’équipe B a mis Justin
    ○ l’équipe C a mis Jil
    ● etc…
A chaque coureur est associé une ou plusieurs catégories (ex: homme, femme, junior, senior, …).
A chaque étape, on saisit l’heure de départ et l’heure d’arrivée de chaque coureur au format
heure minute et seconde (hh:mm:ss).

Pour chaque étape, on attribue des points pour le classement par rang:
    1er : 10 points
    2ème : 6 points
    3ème : 4 points
    4ème : 2 points
    5ème : 1 point

Un coureur: 
    - peut appartenir à plusieurs catégories (ex: homme et junior)
    - peut commencer une étape et la finir le lendemain
    - appartient à une et une seule équipe, il ne peut pas changer d’équipe
    - participe à une étape et selon ses catégories il peut avoir différent points (ex:
    2ème homme et 1er junior)
    - peut participer à plusieurs étapes
    - Les points de l’équipe sont obtenus à partir des points de ses coureurs
    - Une équipe n’est pas obligé de mettre un coureur sur chaque étape
    - Les classements utilisent les points obtenus dans les chronos
    - L’heure de départ pour chaque étape est pareil pour tous les coureurs
    - Règles d’attribution des points si ex aequo
    - exemple il y a 2 coureurs 1er , donc le 3ème coureur sera 2ème
```

Is my db scheme correct and well structured based on the provided context ? Is it following the good practices of database design ?

You can point out any mistakes or improvement if you have some ... 

Here is my db scheme:

/* ============================================================ */

