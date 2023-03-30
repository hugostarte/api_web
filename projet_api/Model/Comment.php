<?php

namespace Model;

class Comment extends Model
{

    public function __construct()
    {
        parent::__construct("commentaires");
    }
    
     public function getAllComment($id)
     {
         $sql = "SELECT * FROM commentaires WHERE id_post = :id";
         $req = $this->db->prepare($sql);
         $req->execute(array(
             "id" => $id
         ));
         $result = $req->fetchAll(\PDO::FETCH_OBJ);
         return $result;
     }
}


?>