<?php

use \PetWorld\Model\Doacao;

$app->post('/doacao/inserir', function(){

    date_default_timezone_set('America/Sao_Paulo');

    if(!isset($_POST["idanimal"])){
        $faltante = "";

        if(!isset($_POST["idanimal"])) $faltante .= "idanimal\n";

        echo json_encode(array(
            "success"=>"false",
            "mensage"=>"POST com falta de informações! - \n" . $faltante
        )); 
        exit;
    }

    $doacao = new Doacao();

    $doacao->setData($_POST);

    $doacao->save();

    echo json_encode($doacao->getValues()); 

    exit;
});

$app->get('/doacao/:iddoacao', function($iddoacao){

    $doacao = new Doacao();
    $doacao->getById($iddoacao);
    echo json_encode($doacao->getValues());
    exit;

});

$app->get('/doacao', function(){

    $doacao = new Doacao();
    $doacao->listAll();
    echo json_encode($doacao->getValues());
    exit;

});

?>