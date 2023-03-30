<?php

namespace Controller;

use stdClass;

class UserController extends Controller
{
    private $userManager;

    public function __construct()
    {
        $this->userManager = new \Model\User();
    }

    function getAll()
    {
        $listuser = $this->userManager->getAll();
        $this->addViewParams("users",$listuser);
        $this->View("listuser");
        
        
        $this->JSON($this->userManager->getAll());
    }

    function getOne($id)
    {

        $this->JSON($this->userManager->getOne($id));
    }

    function create()
    {
        $user = new \stdClass();
        $user->firstname = $_POST["firstname"];
        $user->lastname = $_POST["lastname"];
        $user->birthday = $_POST["birthday"];
        $user->login = $_POST["login"];
        $user->password = $_POST["password"];
        $this->userManager->create($user);

        $this->JSONMessage("Utilisateur créé");
    }

    function update($id)
    {
        $auth = getAuth();
        if($auth){
            if($auth->id == $id){
                $data = json_decode(file_get_contents("php://input"));
                $user = new \stdClass();
                $user->id = $id;
                $user->email = $data->email;
                if ($this->userManager->update($user)) {
                    $this->JSONMessage("Utilisateur mis à jour");
                } else {
                    $this->JSONMessage("Utilisateur non trouvé");
                }
            }else{
                $this->JSONMessage("Vous n'avez pas les droits pour modifier cet utilisateur");
            }
        }
        
    }

    function delete($id)
    {
        if ($this->userManager->delete($id)) {
            $this->JSONMessage("Utilisateur supprimé");
        } else {
            $this->JSONMessage("Utilisateur non trouvé");
        }
    }

    function signin()
    {
        $user = new \stdClass();
        $user->email = $_POST["email"];
        $user->password = password_hash($_POST["password"], PASSWORD_BCRYPT);

        $this->userManager->create($user);

        $this->JSONMessage("Utilisateur créé");
    }

    function login()
    {
        $user = $this->userManager->getUserByEmail($_POST["email"]);
        $response = new stdClass();
        if ($user == false) {
            $response->success = false;
            $response->message = "E-mail incorrect";
        } else {
            if (password_verify($_POST["password"], $user->password)) {
                $response->success = true;
                $data = new stdClass();
                $data->id = $user->id;
                $data->token = \JWT\JWT::encode(array('id' => $user->id),"dz14a68df4s3f4e6z8f4ze681",'HS256');
                $response->data = $data;
            } else {
                $response->success = false;
                $response->message = "Mot de passe incorrect";
            }
        }
        $this->JSON($response);
    }
}
