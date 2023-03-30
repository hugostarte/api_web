<?php

namespace Model;

class Model
{
    private $name;
    protected $db;

    public function __construct($name){
        $this->name = $name;
        $this->db = (\Model\Bdd::getInstance())->db;
    }

    function getAll()
    {
        $req = $this->db->prepare("SELECT * FROM " . $this->name);
        $req->execute();
        $req->setFetchMode(\PDO::FETCH_OBJ);
        return $req->fetchAll();
    }

    function getOne($id)
    {
        $req = $this->db->prepare("SELECT * FROM " . $this->name . " WHERE id=?");
        $req->execute(array($id));
        $req->setFetchMode(\PDO::FETCH_OBJ);
        return $req->fetch();
    }
    
    function create($object)
    {   
        $sql = "INSERT INTO " . $this->name;
        $sqlField = array();
        $sqlValue = array();
        
        foreach($object as $key => $value){
            $sqlField[] = $key;
            $sqlValue[] = $value;
        }

        $sql .= "(". implode(",",$sqlField) .") VALUE(" . implode(",",array_fill(0,count($sqlValue),"?")) . ")";


        $req = $this->db->prepare($sql);
        $req->execute($sqlValue);

        if($req->rowCount() == 1){
            return true;
        }else{
            return false;
        }
    }
    
    function update($object)
    {
        $id = $object->id;
        unset($object->id);

        $sql = "UPDATE " . $this->name . " SET ";

        $sqlField = array();
        $sqlValue = array();

        foreach($object as $key=>$value){
            $sqlField[] = $key . "=?";
            $sqlValue[] = $value;
        }

        $sql .= implode(",",$sqlField) . "WHERE id=?";

        $sqlValue[] = $id;

        $req = $this->db->prepare($sql);
        $req->execute($sqlValue);
        if($req->rowCount() == 1){
            return true;
        }else{
            return false;
        }
    }

    function delete($id)
    {
        $req = $this->db->prepare("DELETE FROM " . $this->name . " WHERE id=?");
        $req->execute(array($id));
        if($req->rowCount() == 1){
            return true;
        }else{
            return false;
        }
    }

    /*
    * Fonction de detection des commentaires suspects
    * Envoi un email en cas de detection de commentaires suspects
    */
    function antiSpam($chaine, $email){
					
        $a_bannir = array('http', 'www', 'bot', 'investissement','robot ','bravo','riche',"https", "www", ".com", ".mx", ".org", ".net", ".co.uk", ".jp", ".ch", ".info", ".me", ".mobi", ".us", ".biz", ".ca", ".ws", ".ag", 
        ".com.co", ".net.co", ".com.ag", ".net.ag", ".it", ".fr", ".tv", ".am", ".asia", ".at", ".be", ".cc", ".de", ".es", ".com.es", ".eu", 
        ".fm", ".in", ".tk", ".com.mx", ".nl", ".nu", ".tw", ".vg", "sex", "porn", "fuck", "buy", "free", "dating", "viagra", "money", "dollars", 
        "payment", "website", "games", "toys", "poker", "cheap", "gratuit");

        $cpt_mots = 0;
        $chaine = strtolower($chaine);
        if(is_array($a_bannir)){
            foreach($a_bannir as $mot){
                $cpt_mots += substr_count($chaine, $mot);
            }
        }
        $message = "Un commentaire suspect a été posté";
        $email = "contact@hugostawiarski.fr";
        $object = "Spam detecte";
        $header = "From: ".$email." \r\n"."Reply-To: ".$email." \r\n"."Content-type: text/html; charset=UTF-8 \r\n";
        
        mail($email, $object, $message, $header);

        return ($cpt_mots > 0 ) ? true : false;
    }
}
