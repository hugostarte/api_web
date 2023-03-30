<?php
    namespace Model;

class User extends \Model\Model{
    public function __construct()
    {
        parent::__construct("user");
    }

    public function getUserByEmail($email)
    {
        $req = $this->db->prepare("SELECT * FROM user WHERE email=?");
        $req->execute(array($email));
        $req->setFetchMode(\PDO::FETCH_OBJ);
        return $req->fetch();
    }
}