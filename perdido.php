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

    $animal = new Perdido();

    $animal->setData($_POST);

    $animal->save();

    echo json_encode($animal->getValues()); 

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
    $perdido->listAll();
    echo json_encode($perdido->getValues());
    exit;

});


?>