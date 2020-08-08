<?php

use \PetWorld\Model\Perdido;

$app->post('/perdido/inserir', function(){
    
    if(!isset($_POST["idusuario"]) ||
    !isset($_POST["idanimal"]) ||
    !isset($_POST["estado"]) ||
    !isset($_POST["cidade"]) ||
    !isset($_POST["descricao"])
    ){
        echo json_encode(array(
            "success"=>"false",
            "mensage"=>"POST com falta de informações!"
        )); 
        exit;
    }

    $perdido = new Perdido();

    $perdido->setData($_POST);

    $perdido->save();

    echo json_encode($perdido->getValues()); 

    exit;

});

$app->post('/perdido/editar', function(){
    
    if(!isset($_POST["idperdido"])
    ){
        echo json_encode(array(
            "success"=>"false",
            "mensage"=>"POST com falta de informações!"
        )); 
        exit;
    }

    $perdido = new Perdido();

    $perdido->getById($_POST["idperdido"]);

    $perdido->setData($_POST);

    $perdido->update();

    echo json_encode($perdido->getValues()); 

    exit;

});


$app->get('/perdido/:idperdido', function($idperdido){

    $perdido = new Perdido();
    $perdido->getById($idperdido);
    echo json_encode($perdido->getValues());
    exit;

});

$app->get('/perdido', function(){

    $perdido = new Perdido();
    echo json_encode($perdido->listAll());
    exit;

});

$app->get('/perdido/usuario/:idusuario', function($idUsuario){

    $perdido = new Perdido();
    $results = $perdido->obterPorUsuario($idUsuario);
    echo json_encode($results);
    exit;

});


?>