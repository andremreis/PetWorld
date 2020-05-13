<?php

use PetWorld\Model\Log;
use \PetWorld\Model\Usuario;

$app->get('/usuario/autenticar/:login/:senha', function($login, $senha){
    
    try {
        $user = Usuario::login($login, $senha);
        echo json_encode($user->getValues()); 
    } catch (Exception $e) {
        echo json_encode(array(
            "success"=>"false",
            "mensage"=>$e->getMessage()
        )); 
    }
    exit;
});

$app->post('/usuario/inserir', function(){
    
    if(!isset($_POST["login"]) ||
    !isset($_POST["senha"]) ||
    !isset($_POST["nome"]) ||
    !isset($_POST["sobrenome"]) ||
    !isset($_POST["sexo"]) ||
    !isset($_POST["nascimento"]) ||
    !isset($_POST["cep"]) ||
    !isset($_POST["rua"]) ||
    !isset($_POST["numero"]) ||
    !isset($_POST["bairro"]) ||
    !isset($_POST["cidade"]) ||
    !isset($_POST["estado"]) ||
    !isset($_POST["telefone"])
    ){
        echo json_encode(array(
            "success"=>"false",
            "mensage"=>"POST com falta de informações!"
        )); 
        exit;
    }

    Log::inserir(json_encode($_POST["nascimento"]));
    Log::inserir(json_encode($_POST["cidade"]));

    $user = new Usuario();

    $user->setData($_POST);

    $user->save();

    echo json_encode($user->getValues());

    exit;

});

$app->get('/usuario/:idUsuario/pets', function($idUsuario){

    echo json_encode(Usuario::getPets($idUsuario));

    exit;

});

$app->get('/usuario', function(){

    echo json_encode(Usuario::listAll());

    exit;

});

$app->get('/usuario/:id', function($idUsuario){

    $user = new Usuario();
    $user->getById($idUsuario);
    echo json_encode($user->getValues());

    exit;

});

// $app->get('/usuario/data/:data', function($data){
//     echo date("Y-m-d", strtotime($data));
// });

?>