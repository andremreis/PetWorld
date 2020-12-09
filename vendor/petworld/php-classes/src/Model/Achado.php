<?php

namespace PetWorld\Model;

use \PetWorld\Model;
use \PetWorld\DB\Sql;

class Achado extends Model{

    public function save()
    {
        date_default_timezone_set('America/Sao_Paulo');

        $sql = new Sql();

        Log::inserir(json_encode($this->getValues()));

        $results = $sql->select("CALL sp_achado_save(:idusuario, :idimagem, :descricaolocal, :descricaoanimal, :estado, :cidade, :acolhido, :dataregistro, :status)", array(
            "idusuario"=>$this->getidusuario(),
            "idimagem"=>$this->getidimagem(),
            "descricaolocal"=>$this->getdescricaolocal(),
            "descricaoanimal"=>$this->getdescricaoanimal(),
            "estado"=>$this->getestado(),
            "cidade"=>$this->getcidade(),
            "acolhido"=>$this->getacolhido(),
            "dataregistro"=>date('Y-m-d H-i-s'),
            "status"=>"1"
        ));

        $this->setData($results[0]);

    }

    public function update()
    {

        $sql = new Sql();

        $results = $sql->select("CALL sp_achado_update_save(:idAchado, :idUsuario, :idImagem, :descricaoLocal, :descricaoAnimal, :estado, :cidade, :acolhido, :status)", array(
            "idAchado"=>$this->getidAchado(),
            "idUsuario"=>$this->getidUsuario(),
            "idImagem"=>$this->getidImagem(),
            "descricaoLocal"=>$this->getdescricaoLocal(),
            "descricaoAnimal"=>$this->getdescricaoAnimal(),
            "estado"=>$this->getestado(),
            "cidade"=>$this->getcidade(),
            "acolhido"=>$this->getacolhido(),
            "status"=>$this->getstatus()
        ));

        $this->setData($results[0]);

    }

    public function getById($idachado)
    {
        $sql = new Sql();

        $results = $sql->select("SELECT * FROM achado a INNER JOIN imagem i ON i.idImagem = a.idImagem WHERE a.idachado = :idachado", [
            ":idachado"=>$idachado
        ]);

        $this->setData($results[0]);

    }

    public function obterPorUsuario($idUsuario)
    {
        $sql = new Sql();

        $results = $sql->select("SELECT * FROM achado a LEFT JOIN imagem i ON a.idImagem = i.idImagem WHERE a.idUsuario = :idUsuario", [
            ":idUsuario"=>$idUsuario
        ]);

        return $results;

    }
    
    public function listAll()
    {

        $sql = new Sql();

        $results = $sql->select("SELECT * FROM achado a INNER JOIN imagem i ON i.idImagem = a.idImagem WHERE a.status = 1 ORDER BY a.dataRegistro DESC");

        return $results;
        
    }

}

?>