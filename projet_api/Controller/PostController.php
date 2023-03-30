<?php

namespace Controller;

date_default_timezone_set('Europe/Paris'); // Définit le fuseau horaire par défaut à Europe/Paris
use stdClass;

class PostController extends Controller
{
    private $postManager;
    private $commentManager;

    public function __construct()
    {
        $this->postManager = new \Model\Post(); // Instancie le gestionnaire de posts
        $this->commentManager = new \Model\Comment(); // Instancie le gestionnaire de commentaires
    }

    function getAll()
    {
        $listpost = $this->postManager->getAll(); // Récupère tous les posts
        $this->addViewParams("post",$listpost); // Ajoute les posts à la liste des paramètres de la vue
        $this->View("listpost"); // Affiche la vue "listpost"
    }

    function getOne($id)
    {
        $this->JSON($this->postManager->getOne($id)); // Récupère un post en format JSON

        $listcomment = $this->commentManager->getOne($id); // Récupère les commentaires pour un post spécifique
        $this->addViewParams("comment",$listcomment); // Ajoute les commentaires à la liste des paramètres de la vue
        $this->View("listcomment"); // Affiche la vue "listcomment"
    }

    function create()
    {
        $post = new \stdClass(); // Crée un nouvel objet vide
        $post->firstname = htmlentities($_POST["firstname"]); // Assigne la valeur postée de "firstname" à l'attribut "firstname" de l'objet
        $post->lastname =  htmlentities($_POST["lastname"]); // Assigne la valeur postée de "lastname" à l'attribut "lastname" de l'objet
        $post->content = htmlentities($_POST["content"]); // Assigne la valeur postée de "content" à l'attribut "content" de l'objet
        $post->postdate = date("m-d-Y H:i:s"); // Assigne la date et l'heure courante à l'attribut "postdate" de l'objet et l'enregistre en base de données
        $this->postManager->create($post); // Crée un nouveau post avec les données de l'objet

        $this->JSONMessage("Votre post a été créé"); // Renvoie un message de confirmation au format JSON
    }

    function update($id)
    {
        $auth = getAuth(); // Vérifie si l'utilisateur est authentifié
        if($auth){
            if($auth->id == $id){ // Vérifie si l'utilisateur est autorisé à modifier ce post
                $data = json_decode(file_get_contents("php://input")); // Récupère les données JSON postées
                $post = new \stdClass(); // Crée un nouvel objet vide
                $post->id = $id; // Assigne l'identifiant du post à l'attribut "id" de l'objet
                $post->email = $data->email; // Assigne la valeur postée de "email" à l'attribut "email" de l'objet
                if ($this->postManager->update($post)) { // Met à jour le post avec les nouvelles données
                    $this->JSONMessage("Post mis à jour"); // Renvoie un message de confirmation au format JSON
                } else {
                   
