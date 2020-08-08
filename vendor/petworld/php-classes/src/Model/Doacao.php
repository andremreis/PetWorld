<?php

namespace PetWorld\Model;

use \PetWorld\Model;
use \PetWorld\DB\Sql;

class Doacao extends Model{

    public function save()
    {
        date_default_timezone_set('America/Sao_Paulo');

        $sql = new Sql();

        Log::inserir(json_encode($this->getValues()));

        $results = $sql->select("CALL sp_doacao_save(:idanimal, :dataregistro)", array(
            "idanimal"=>$this->getidanimal(),
            "dataregistro"=>date('Y-m-d H-i-s')
        ));

        $this->setData($results[0]);

    }

    public function getById($iddoacao)
    {
        $sql = new Sql();

        $results = $sql->select("SELECT * FROM doacao d WHERE d.iddoacao = :iddoacao", [
            ":iddoacao"=>$iddoacao
        ]);

        $animal = new Animal();
        $animal->getById($results[0]["idAnimal"]);
        $results[0]["Animal"] = $animal->getValues();

        $usuario = new Usuario();
        $usuario->getById($results[0]["idAntigoDono"]);
        $results[0]["AntigoDono"] = $usuario->getValues();

        if($results[0]["idNovoDono"] != null){
            $usuario->getById($results[0]["idNovoDono"]);
            $results[0]["NovoDono"] = $usuario->getValues();    
        }

        $this->setData($results[0]);

    }

    public function obterPorUsuario($idUsuario)
    {
        $sql = new Sql();

        $results = $sql->select("SELECT * FROM doacao d WHERE d.idAntigoDono = :idUsuario", [
            ":idUsuario"=>$idUsuario
        ]);

        foreach($results as &$doacao)
        {
            $animal = new Animal();
            $animal->getById($doacao["idAnimal"]);
            $doacao["Animal"] = $animal->getValues();

            $usuario = new Usuario();
            $usuario->getById($doacao["idAntigoDono"]);
            $doacao["AntigoDono"] = $usuario->getValues();

            if($doacao["idNovoDono"] != null){
                $usuario = new Usuario();
                $usuario->getById($doacao["idNovoDono"]);
                $doacao["NovoDono"] = $usuario->getValues();
            }
        }

        return $results;

    }
    
    public function listAll()
    {

        $sql = new Sql();

        $results = $sql->select("SELECT * FROM doacao d ORDER BY d.dataRegistro");

        foreach($results as &$doacao)
        {
            $animal = new Animal();
            $animal->getById($doacao["idAnimal"]);
            $doacao["Animal"] = $animal->getValues();

            $usuario = new Usuario();
            $usuario->getById($doacao["idAntigoDono"]);
            $doacao["AntigoDono"] = $usuario->getValues();

            if($doacao["idNovoDono"] != null){
                $usuario = new Usuario();
                $usuario->getById($doacao["idNovoDono"]);
                $doacao["NovoDono"] = $usuario->getValues();
            }
        }

        return $results;
        
    }

}

?>