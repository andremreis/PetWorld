<?php

namespace PetWorld\Model;

use \PetWorld\Model;
use \PetWorld\DB\Sql;

class Gosto extends Model{

    public function save()
    {

        $sql = new Sql();

        $results = $sql->select("CALL sp_gosto_save(:idusuario, :nome, :especie, :raca, :sexo, :cor, :porte, :pelo, :filhote)", array(
            "idusuario"=>$this->getidusuario(),
            "nome"=>$this->getnome(),
            "especie"=>$this->getespecie(),
            "raca"=>$this->getraca(),
            "sexo"=>$this->getsexo(),
            "cor"=>$this->getcor(),
            "porte"=>$this->getporte(),
            "pelo"=>$this->getpelo(),
            "filhote"=>$this->getfilhote()
        ));

        $this->setData($results[0]);

    }

    public function getById($idGosto)
    {
        $sql = new Sql();

        $results = $sql->select("SELECT * FROM gosto g WHERE idGosto = :idGosto", [
            ":idGosto"=>$idGosto
        ]);

        $this->setData($results[0]);

    }

    public function getByUsuario($idUsuario)
    {
        $sql = new Sql();

        $results = $sql->select("SELECT * FROM gosto g WHERE idUsuario = :idUsuario", [
            ":idUsuario"=>$idUsuario
        ]);

        return $results;

    }

}

?>