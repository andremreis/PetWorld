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

}

?>