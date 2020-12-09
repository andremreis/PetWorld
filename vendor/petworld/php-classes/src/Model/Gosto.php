<?php

namespace PetWorld\Model;

use \PetWorld\Model;
use \PetWorld\DB\Sql;

class Gosto extends Model{

    public function save()
    {

        $sql = new Sql();

        $results = $sql->select("CALL sp_gosto_save(:idusuario, :especie, :raca, :sexo, :cor, :porte, :pelo, :filhote, :principal, :dataCriacao)", array(
            ":idusuario"=>$this->getidUsuario(),
            ":especie"=>$this->getespecie(),
            ":raca"=>$this->getraca(),
            ":sexo"=>$this->getsexo(),
            ":cor"=>$this->getcor(),
            ":porte"=>$this->getporte(),
            ":pelo"=>$this->getpelo(),
            ":filhote"=>$this->getfilhote(),
            ":principal"=>$this->getprincipal(),
            ":dataCriacao"=>$this->getdataCriacao(),
        ));

        $this->setData($results[0]);

    }

    public static function removerRegistro($idGosto)
    {
        $sql = new Sql();

        $sql->query("DELETE FROM gosto WHERE idGosto = :ID", [
            ":ID"=>$idGosto
        ]);
    }

    public function getById($idGosto)
    {
        $sql = new Sql();

        $results = $sql->select("SELECT * FROM gosto g WHERE idGosto = :idGosto", [
            ":idGosto"=>$idGosto
        ]);

        $this->setData($results[0]);

    }

    // Mudei pra static, se der BO remover
    public static function getByUsuario($idUsuario)
    {
        $sql = new Sql();

        $results = $sql->select("SELECT * FROM gosto g WHERE idUsuario = :idUsuario", [
            ":idUsuario"=>$idUsuario
        ]);

        return $results;

    }

    public function obterAnimalDeAcordoComGostos($idUsuario) : Animal
    {
        $gostos = $this->getByUsuario($idUsuario);

        $especie = "";
        $raca = "";
        $sexo = "";
        $cor = "";
        $porte = "";
        $pelo = "";
        $filhote = "";

        foreach ($gostos as $key => $value) {

            $diffEspecie = array_diff(explode(";", $value["especie"]), explode(";", $especie));
            if(strlen($especie) > 0 && count($diffEspecie) > 0) $especie .= ";";
            $especie .= implode( ";", $diffEspecie);

            $diffRaca = array_diff(explode(";", $value["raca"]), explode(";", $raca));
            if(strlen($raca) > 0 && count($diffRaca) > 0) $raca .= ";";
            $raca .= implode( ";", $diffRaca);

            $diffSexo = array_diff(explode(";", $value["sexo"]), explode(";", $sexo));
            if(strlen($sexo) > 0 && count($diffSexo) > 0) $sexo .= ";";
            $sexo .= implode( ";", $diffSexo);

            $diffCor = array_diff(explode(";", $value["cor"]), explode(";", $cor));
            if(strlen($cor) > 0 && count($diffCor) > 0) $cor .= ";";
            $cor .= implode( ";", $diffCor);

            $diffPorte = array_diff(explode(";", $value["porte"]), explode(";", $porte));
            if(strlen($porte) > 0 && count($diffPorte) > 0) $porte .= ";";
            $porte .= implode( ";", $diffPorte);

            $diffPelo = array_diff(explode(";", $value["pelo"]), explode(";", $pelo));
            if(strlen($pelo) > 0 && count($diffPelo) > 0) $pelo .= ";";
            $pelo .= implode( ";", $diffPelo);

            $diffFilhote = array_diff(explode(";", $value["filhote"]), explode(";", $filhote));
            if(strlen($filhote) > 0 && count($diffFilhote) > 0) $filhote .= ";";
            $filhote .= implode( ";", $diffFilhote);
        }

        $animal = new Animal();
        $data = [
            "especie"=>$especie,
            "raca"=>$raca,
            "sexo"=>$sexo,
            "cor"=>$cor,
            "porte"=>$porte,
            "pelo"=>$pelo,
            "filhote"=>$filhote
        ];
        $animal->setData($data);

        return $animal;
    }

}

?>