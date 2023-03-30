<?php

namespace Controller;
date_default_timezone_set('Europe/Paris');
use stdClass;

class PostController extends Controller
{
    private $postManager;

    public function __construct()
    {
        $this->postManager = new \Model\Post();
    }

    function getAll()
    {
        $this->JSON($this->postManager->getAll());
    }

    function getOne($id)
    {
        $this->JSON($this->postManager->getOne($id));
        $this->JSON($this->postManager->getComments($id)); 
    }

    function create()
    {
        $post = new \stdClass();
        $post->firstname = htmlentities($_POST["firstname"]);
        $post->lastname =  htmlentities($_POST["lastname"]);
        $post->content = htmlentities($_POST["content"]);
        $post->postdate = date("m-d-Y H:i:s"); // Enregistre en bd la date et l'heure courante
        $this->postManager->create($post);

        $this->JSONMessage("Votre post a été créé");
    }

    function update($id)
    {
        $auth = getAuth();
        if($auth){
            if($auth->id == $id){
                $data = json_decode(file_get_contents("php://input"));
                $post = new \stdClass();
                $post->id = $id;
                $post->email = $data->email;
                if ($this->postManager->update($post)) {
                    $this->JSONMessage("Post mis à jour");
                } else {
                    $this->JSONMessage("Post non trouvé");
                }
            }else{
                $this->JSONMessage("Vous n'avez pas les droits pour modifier ce post");
            }
        }
        
    }

    function delete($id)
    {
        if ($this->postManager->delete($id)) {
            $this->JSONMessage("Post supprimé");
        } else {
            $this->JSONMessage("Post non trouvé");
        }
    }
    


   
}
