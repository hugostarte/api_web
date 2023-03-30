<?php

namespace Controller;

class Controller
{
    private $viewParams; // Déclaration de la variable qui va stocker les paramètres de la vue

    public function __construct()
    {
        $this->viewParams = []; // Initialisation de la variable qui va stocker les paramètres de la vue
    }

    public function JSON($data){ // Fonction qui permet de renvoyer les données au format JSON
        header("Content-Type: application/json"); // Définition de l'en-tête HTTP pour le type de contenu JSON
        echo json_encode($data); // Encodage des données au format JSON et envoi de la réponse au client
    }

    public function JSONMessage($message){ // Fonction qui permet de renvoyer un message d'erreur au format JSON
        $res = new \stdClass(); // Création d'un objet vide
        $res->message = $message; // Ajout du message dans l'objet
        $this->JSON($res); // Appel de la fonction JSON pour envoyer la réponse au client
    }

    public function View($template){ // Fonction qui permet d'afficher une vue HTML
        extract($this->viewParams); // Extraction des variables passées en paramètres pour pouvoir les utiliser dans la vue
        header("Content-Type: text/html"); // Définition de l'en-tête HTTP pour le type de contenu HTML
        include("View/".$template.".php"); // Inclusion du fichier de la vue
    }

    public function addViewParams($name,$value){ // Fonction qui permet d'ajouter des paramètres à la vue
        $this->viewParams[$name] = $value; // Ajout du paramètre dans le tableau des paramètres de la vue
    }
}
