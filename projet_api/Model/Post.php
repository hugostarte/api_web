<?php

namespace Model;

class Post extends Model
{

    public function __construct()
    {
        parent::__construct("post");
    }

    public function getComments($object)
    {
        $req = $this->db->prepare("SELECT * FROM commentaires WHERE post_id=?");
        $req->execute(array($object->id));
        $req->setFetchMode(\PDO::FETCH_OBJ);
        return $req->fetchAll();
    }
    public function updateComments($content,$id){
        $req = $this->db->prepare("UPDATE commentaires SET content=? WHERE post_id=?");
        $req->execute(array($content,$id));
        $req->setFetchMode(\PDO::FETCH_OBJ);
        return $req->fetchAll();
    }
    
}


?>