<?php

namespace PetWorld\Model;

use \PetWorld\Model;
use \PetWorld\DB\Sql;

class Log extends Model{

    public static function inserir($descricao)
    {
        
        $sql = new Sql();

        $sql->query("INSERT INTO `log` (`descricao`, `data`) VALUES (:descricao, :datatime);", [
            ":descricao"=>$descricao,
            ":datatime"=>date('Y-m-d H:i:s')
        ]);


    }

}

?>