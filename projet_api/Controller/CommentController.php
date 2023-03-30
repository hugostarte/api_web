namespace Controller;

use stdClass;

class UserController extends Controller
{
    // Une variable privée pour stocker le modèle d'utilisateur
    private $userManager;

    // Le constructeur initialise le modèle d'utilisateur
    public function __construct()
    {
        // Initialise un nouvel objet de modèle d'utilisateur
        $this->userManager = new \Model\User();
    }

    // Méthode pour récupérer tous les utilisateurs
    function getAll()
    {
        // Récupère tous les utilisateurs du modèle d'utilisateur
        $listuser = $this->userManager->getAll();

        // Ajoute les utilisateurs à la vue pour être affichés
        $this->addViewParams("users",$listuser);

        // Affiche la vue "listuser" avec les utilisateurs
        $this->View("listuser");
    }

    // Méthode pour récupérer un utilisateur spécifique en fonction de son identifiant
    function getOne($id)
    {
        // Récupère un utilisateur spécifique en fonction de son identifiant
        $user = $this->userManager->getOne($id);

        // Retourne l'utilisateur sous forme de réponse JSON
        $this->JSON($user);
    }

    // Méthode pour créer un nouvel utilisateur
    function create()
    {
        // Crée un nouvel objet utilisateur et initialise ses propriétés à partir des données POST
        $user = new \stdClass();
        $user->firstname = $_POST["firstname"];
        $user->lastname = $_POST["lastname"];
        $user->birthday = $_POST["birthday"];
        $user->login = $_POST["login"];
        $user->password = $_POST["password"];

        // Ajoute l'utilisateur au modèle d'utilisateur
        $this->userManager->create($user);

        // Retourne une réponse JSON indiquant que l'utilisateur a été créé
        $this->JSONMessage("Utilisateur créé");
    }

    // Méthode pour mettre à jour les informations d'un utilisateur existant
    function update($id)
    {
        // Vérifie l'authentification de l'utilisateur
        $auth = getAuth();
        if($auth){
            // Vérifie que l'utilisateur met à jour ses propres informations
            if($auth->id == $id){
                // Récupère les données JSON de la requête et crée un nouvel objet utilisateur
                $data = json_decode(file_get_contents("php://input"));
                $user = new \stdClass();
                $user->id = $id;
                $user->email = $data->email;

                // Met à jour les informations de l'utilisateur dans le modèle d'utilisateur
                if ($this->userManager->update($user)) {
                    // Retourne une réponse JSON indiquant que l'utilisateur a été mis à jour
                    $this->JSONMessage("Utilisateur mis à jour");
                } else {
                    // Retourne une réponse JSON indiquant que l'utilisateur n'a pas été trouvé
                    $this->JSONMessage("Utilisateur non trouvé");
                }
            }else{
                // Retourne une réponse JSON indiquant que l'utilisateur n'a pas les droits pour modifier cet utilisateur
                $this->JSONMessage("Vous n'avez pas les droits pour modifier cet utilisateur");
            }
        }
    }

    // Méthode pour supprimer un utilisateur spécifique en fonction de son identifiant
    function delete($id)
    {
        // Supprime l'utilisateur du modèle d'utilisateur en fonction de son ident
