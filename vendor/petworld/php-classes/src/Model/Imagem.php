<?php

namespace PetWorld\Model;

use \PetWorld\Model;
use \PetWorld\DB\Sql;

class Imagem extends Model{

    public static function inserir($url)
    {
        
        $sql = new Sql();

        return $sql->selectComId("INSERT INTO `imagem` (`url`) VALUES (:url);", [
            ":url"=>$url
        ]);

    }

    public static function remover($idImagem)
    {
        $sql = new Sql();

        $result = $sql->select("SELECT * FROM imagem WHERE idImagem = :ID", [
            ":ID"=>$idImagem
        ]);

        $arq = $_SERVER['DOCUMENT_ROOT'] . '/PetWorld/' . $result[0]["url"];

        if(file_exists($arq)){
            unlink($arq);
        }
    }

    public static function removerRegistro($idImagem)
    {
        $sql = new Sql();

        $sql->query("DELETE FROM imagem WHERE idImagem = :ID", [
            ":ID"=>$idImagem
        ]);
    }

}

?>