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
}
