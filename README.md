# Projet cours api web

Cahier des charges :    

Réseau social d'entreprise

Fonctionnalités minimum (+ routes)

----------------------------------

Inscription (JSON)
POST /auth/signin 

Connexion (JSON)
POST /auth/login

-----------------------------------

Nouveau post (JSON)
POST /post

Récupérer tous les posts (View)
GET /post

Récupérer un post et tous les commentaires associés (View)
GET /post/<id>

Modifier un post (JSON)
PUT /post

Supprimer un post (JSON)
DELETE /post

----------------------------------

Ajouter un commentaire (à un post) (JSON)
POST /post/<id>/comment

Supprimer un commentaire (JSON)
DELETE /comment/id

----------------------------------

