<?php

namespace PetWorld\Model;

use \PetWorld\Model;
use \PetWorld\DB\Sql;

class Animal extends Model{

    public function save()
    {

        $sql = new Sql();

        $results = $sql->select("CALL sp_animal_save(:idusuario, :nome, :especie, :raca, :sexo, :cor, :porte, :pelo, :filhote)", array(
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

    public function getById($idAnimal)
    {
        $sql = new Sql();

        $results = $sql->select("SELECT * FROM animal a WHERE idAnimal = :idAnimal", [
            ":idAnimal"=>$idAnimal
        ]);

        $results[0]["Galeria"] = $this->getGaleria($idAnimal);

        $this->setData($results[0]);

    }

    public static function getGaleria($idAnimal)
    {

        $sql = new Sql();

        return $sql->select(
            "SELECT i.url " . 
            "FROM galeria g " .  
            "INNER JOIN imagem i ON g.idImagem = i.idImagem " . 
            "WHERE g.idAnimal = {$idAnimal} " .  
            "ORDER BY g.idGaleria "
        );
        
    }

    public function salvarGaleria()
    {

        $sql = new Sql();

        $sql->query("INSERT INTO `galeria` (`idAnimal`, `idImagem`) VALUES (:idanimal, :idimagem)", [
            "idanimal"=>$this->getidanimal(),
            "idimagem"=>$this->getidimagem()
        ]);

    }

    public static function listAll($exceto = 0)
    {
        $Animais = array();

        $sql = new Sql();

        $result = $sql->select(
            "SELECT *  
            FROM animal a   
            WHERE (:Exceto = 0 || a.idAnimal <> :Exceto)   
            ORDER BY a.idAnimal ",
            [
                "Exceto"=>$exceto
            ]
        );

        foreach($result as $animal){
            $obj = new Animal();

            $obj->setGaleria(Animal::getGaleria($animal["idAnimal"]));

            $obj->setData($animal);
            array_push($Animais, $obj);
        }

        return $Animais;    

    }

}

?>