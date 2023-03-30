<?php

namespace Controller;
date_default_timezone_set('Europe/Paris');
use stdClass;

class CommentController extends Controller
{
    private $commentManager;

    public function __construct()
    {
        $this->commentManager = new \Model\Comment();
        
    }

    function getAll()
    {
        $this->JSON($this->commentManager->getAll());
        $listcomment = $this->commentManager->getAll();
        $this->addViewParams("comment",$listcomment);
        $this->View("listcomment");
    }

    function getOne($id)
    {
        $this->JSON($this->commentManager->getOne($id));
        $listcomment = $this->commentManager->getOne($id);
        $this->addViewParams("comment",$listcomment);
        $this->View("listcomment");
    }

    function create()
    {
        $comment = new \stdClass();
        $comment->firstname = htmlentities($_POST["firstname"]);
        $comment->lastname =  htmlentities($_POST["lastname"]);
        $comment->lastname =  htmlentities($_POST["post_id"]);
        $comment->content = htmlentities($_POST["content"]);
        $comment->commentdate = date("m-d-Y H:i:s"); // Enregistre en bd la date et l'heure courante
        
         // Utilisation de la fonction antisapm
         if($this->commentManager->antispam($_POST["content"], "contact@hugostawiarski.fr") ){
            $this->JSONMessage("Votre comment a été bloqué");
            $comment->content = htmlentities($_POST["content"]);
            $this->commentManager->create($comment);
        } else {
            $this->JSONMessage("Votre comment a été créé");
        }
    }

    function update($id)
    {
        $auth = getAuth();
        if($auth){
            if($auth->id == $id){
                $data = json_decode(file_get_contents("php://input"));
                $comment = new \stdClass();
                $comment->id = $id;
                $comment->email = $data->email;
                if ($this->commentManager->update($comment)) {
                    $this->JSONMessage("Commentaire mis à jour");
                } else {
                    $this->JSONMessage("Commentaire non trouvé");
                }
            }else{
                $this->JSONMessage("Vous n'avez pas les droits pour modifier ce commentaire");
            }
        }
        
    }

    function delete($id)
    {
        if ($this->commentManager->delete($id)) {
            $this->JSONMessage("Commentaire supprimé");
        } else {
            $this->JSONMessage("Commentaire non trouvé");
        }
    }
    


   
}