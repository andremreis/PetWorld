<?php

use \PetWorld\Model\Gosto;

$app->post('/gosto/inserir', function(){

    date_default_timezone_set('America/Sao_Paulo');

    if(!isset($_POST["idUsuario"])){
        $faltante = "";

        if(!isset($_POST["idUsuario"])) $faltante .= "idUsuario\n";

        echo json_encode(array(
            "success"=>"false",
            "mensage"=>"POST com falta de informações! - \n" . $faltante
        )); 
        exit;
    }

    
    $gostos = Gosto::getByUsuario($_POST["idUsuario"]);

    $gosto = new Gosto();
    $gosto->setData($_POST);
    $gosto->setdataCriacao(date('Y-m-d H:i:s'));

    // Se não tiver nenhum, inserir o primeiro como principal
    if($gostos == null || count($gostos) == 0){

        $gosto->setprincipal(1);

    }else{  

        $gosto->setprincipal(0);

    }

    if($gosto->getprincipal() == 0){

        if(count($gostos) > 1){
            
            $dataInicial = date('Y-m-d', strtotime($gostos[1]["dataCriacao"]));
            $dataFinal = date('Y-m-d');

            // Calcula a diferença em segundos entre as datas
            $diferenca = strtotime($dataFinal) - strtotime($dataInicial);

            //Calcula a diferença em dias
            $dias = floor($diferenca / (60 * 60 * 24));

            // Substituir o registro
            $gosto->removerRegistro($gostos[1]["idGosto"]);

            if($dias < 7){

                // Atualizar o registro
                $str = (strlen($gosto->getespecie()) > 0 && strlen($gostos[1]["especie"]) > 0) 
                    ? $gosto->getespecie() . ";" . $gostos[1]["especie"] 
                    : $gosto->getespecie() . $gostos[1]["especie"];
                $gosto->setespecie($str);

                $str = (strlen($gosto->getraca()) > 0 && strlen($gostos[1]["raca"] ) > 0) 
                    ? $gosto->getraca() . ";" . $gostos[1]["raca"] 
                    : $gosto->getraca() . $gostos[1]["raca"];
                $gosto->setraca($str);

                $str = (strlen($gosto->getsexo()) > 0 && strlen($gostos[1]["sexo"]) > 0) 
                    ? $gosto->getsexo() . ";" . $gostos[1]["sexo"] 
                    : $gosto->getsexo() . $gostos[1]["sexo"];
                $gosto->setsexo($str);

                $str = (strlen($gosto->getcor()) > 0 && strlen($gostos[1]["cor"]) > 0) 
                    ? $gosto->getcor() . ";" . $gostos[1]["cor"] 
                    : $gosto->getcor() . $gostos[1]["cor"];
                $gosto->setcor($str);

                $str = (strlen($gosto->getporte()) > 0 && strlen($gostos[1]["porte"]) > 0) 
                    ? $gosto->getporte() . ";" . $gostos[1]["porte"] 
                    : $gosto->getporte() . $gostos[1]["porte"];
                $gosto->setporte($str);

                $str = (strlen($gosto->getpelo()) > 0 && strlen($gostos[1]["pelo"]) > 0) 
                    ? $gosto->getpelo() . ";" . $gostos[1]["pelo"] 
                    : $gosto->getpelo() . $gostos[1]["pelo"];
                $gosto->setpelo($str);

                $str = (strlen($gosto->getfilhote()) > 0) 
                    ? $gosto->getfilhote() 
                    : $gostos[1]["filhote"];
                $gosto->setfilhote($str);
                
                $gosto->setdataCriacao($gostos[1]["dataCriacao"]);

            }
        }

    }    

    $gosto->save();

    echo json_encode($gosto->getValues()); 

    exit;
});

?>