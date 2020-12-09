<?php

namespace PetWorld\Model;

use \PetWorld\Model;
use \PetWorld\DB\Sql;

class Perdido extends Model{

    public function save()
    {
        date_default_timezone_set('America/Sao_Paulo');

        $sql = new Sql();

        $results = $sql->select("CALL sp_perdido_save(:idusuario, :idanimal, :estado, :cidade, :descricao, :dataregistro, :status)", array(
            "idusuario"=>$this->getidusuario(),
            "idanimal"=>$this->getidanimal(),
            "estado"=>$this->getestado(),
            "cidade"=>$this->getcidade(),
            "descricao"=>$this->getdescricao(),
            "dataregistro"=>date('Y-m-d H-i-s'),
            "status"=>"1"
        ));

        $this->setData($results[0]);

    }

    public function update()
    {
        
        $sql = new Sql();

        $results = $sql->select("CALL sp_perdido_update_save(:idperdido, :idusuario, :idanimal, :estado, :cidade, :descricao, :status)", array(
            "idperdido"=>$this->getidperdido(),
            "idusuario"=>$this->getidusuario(),
            "idanimal"=>$this->getidanimal(),
            "estado"=>$this->getestado(),
            "cidade"=>$this->getcidade(),
            "descricao"=>$this->getdescricao(),
            "status"=>$this->getstatus(),
        ));

        $this->setData($results[0]);

    }

    public function getById($idPerdido)
    {
        $sql = new Sql();

        $results = $sql->select("SELECT * FROM perdido p WHERE idPerdido = :idPerdido", [
            ":idPerdido"=>$idPerdido
        ]);

        $animal = new Animal();
        $animal->getById($results[0]["idAnimal"]);

        $results[0]["Animal"] = $animal->getValues();

        $this->setData($results[0]);

    }

    public function obterPorUsuario($idUsuario)
    {
        $sql = new Sql();

        $results = $sql->select("SELECT * FROM perdido p WHERE idUsuario = :idUsuario", [
            ":idUsuario"=>$idUsuario
        ]);

        foreach($results as &$perdido)
        {
            $animal = new Animal();
            $animal->getById($perdido["idAnimal"]);

            $perdido["Animal"] = $animal->getValues();
        }

        return $results;

    }
    
    public function listAll()
    {

        $sql = new Sql();

        $results = $sql->select("SELECT * FROM perdido p ORDER BY p.dataRegistro DESC");

        foreach($results as &$perdido)
        {
            $animal = new Animal();
            $animal->getById($perdido["idAnimal"]);

            $perdido["Animal"] = $animal->getValues();
        }

        return $results;
        
    }

}

?>