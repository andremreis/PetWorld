<?php

use \PetWorld\Model\Gosto;
use \PetWorld\Model\Animal;
use \PetWorld\Model\Usuario;
use \PetWorld\Model\Recomendacao;
use \PetWorld\Model\BaseEnum;

$app->get('/recomendacao/animal/:idAnimal', function($idAnimal){

    $recomendacao = new Recomendacao();

    $animal1 = new Animal();
    $animal2 = new Animal();

    $animal1->getById(1);
    $animal2->getById(44);

    $data = [
        "especie"=>"Gato; Coelho",
        "raca"=>"Virlaata",
        "sexo"=>"M",
        "cor"=>"preto; cinza",
        "porte"=>"medio",
        "pelo"=>"Longa",
        "filhote"=>"0"
    ];

    $animal1->setData($data);

    //$euclidiana = $recomendacao->euclidianaAnimal($animal1, $animal2);
    //echo $euclidiana;

    $teste = $recomendacao->getSimilares(BaseEnum::Animal, $animal1);
    echo json_encode($teste);

});

$app->get('/recomendacao/usuario/:idUsuario', function($idUsuario){

    $recomendacao = new Recomendacao();

    $usuario1 = new Usuario();
    $usuario1->setidUsuario(1);

    $teste = $recomendacao->getSimilares(BaseEnum::Usuario, $usuario1);
    echo json_encode($teste);

});

$app->get('/recomendacao/GostoPessoal', function($idAnimal){

    $recomendacao = new Recomendacao();

    $animal1 = new Animal();
    $animal2 = new Animal();

    $animal1->getById(1);
    $animal2->getById(44);

    //$euclidiana = $recomendacao->euclidianaAnimal($animal1, $animal2);
    //echo $euclidiana;

    $teste = $recomendacao->getSimilares(BaseEnum::Animal, $animal1);
    echo json_encode($teste);

});

// Recomendações Abaixo

$app->get('/recomendacao/colaborativa/:idUsuario', function($idUsuario){

    $recomendacao = new Recomendacao();
    $usuario = new Usuario();
    $usuario->getById($idUsuario);

    $teste = $recomendacao->getRecomendacoesUsuario($usuario);
    echo json_encode($teste);

});

$app->get('/recomendacao/pessoal/:idUsuario', function($idUsuario){

    $recomendacao = new Recomendacao();
    $usuario = new Usuario();
    $usuario->getById($idUsuario);

    $teste = $recomendacao->getRecomendacoesItem($usuario);
    echo json_encode($teste);

});


?>