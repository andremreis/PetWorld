<?php

use \PetWorld\Model\Doacao;

$app->post('/doacao/inserir', function(){

    date_default_timezone_set('America/Sao_Paulo');

    if(!isset($_POST["idanimal"])){
        $faltante = "";

        if(!isset($_POST["idAnimal"])) $faltante .= "idAnimal\n";

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

$app->post('/doacao/editar', function(){
    
    if(!isset($_POST["idDoacao"])){
        echo json_encode(array(
            "success"=>"false",
            "mensage"=>"POST com falta de informações!"
        )); 
        exit;
    }

    $doacao = new Doacao();

    $doacao->getById($_POST["idDoacao"]);

    $doacao->setData($_POST);

    if(!isset($_POST["DataDoacao"])){
        $doacao->setDataDoacao(date('Y-m-d H-i-s'));
    }

    $doacao->update();

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
    echo json_encode($doacao->listAll());
    exit;

});

$app->get('/doacao/usuario/:idusuario', function($idUsuario){

    $doacao = new Doacao();
    $results = $doacao->obterPorUsuario($idUsuario);
    echo json_encode($results);
    exit;

});

?>