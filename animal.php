<?php

use \PetWorld\Model\Animal;
use \PetWorld\Model\Log;
use \PetWorld\Model\Imagem;

const DIRETORIO_IMAGENS = "res/app/img/animais";

$app->post('/animal/inserir', function(){
    
    if(!isset($_POST["idusuario"]) ||
    !isset($_POST["nome"]) ||
    !isset($_POST["especie"]) ||
    !isset($_POST["raca"]) ||
    !isset($_POST["sexo"]) ||
    !isset($_POST["cor"]) ||
    !isset($_POST["pelo"]) ||
    !isset($_POST["porte"]) ||
    !isset($_POST["filhote"])
    ){
        echo json_encode(array(
            "success"=>"false",
            "mensage"=>"POST com falta de informações!"
        )); 
        exit;
    }

    $animal = new Animal();

    $animal->setData($_POST);

    $animal->save();

    echo json_encode($animal->getValues()); 

    exit;

});

$app->post('/animal/galeria', function(){

    date_default_timezone_set('America/Sao_Paulo');

    Log::inserir("POST: " . json_encode($_POST));
    Log::inserir("FILES: " . json_encode($_FILES));
    
    if(!isset($_POST["idanimal"]) ||
    !isset($_FILES["file"])){
        echo json_encode(array(
            "success"=>"false",
            "mensage"=>"POST com falta de informações!"
        )); 
        exit;
    }

    if(!file_exists(DIRETORIO_IMAGENS)){
        mkdir(DIRETORIO_IMAGENS, 0777, true);
    }

    if(!file_exists(DIRETORIO_IMAGENS . "/" . $_POST['idanimal'])){
        mkdir(DIRETORIO_IMAGENS . "/" . $_POST['idanimal'], 0777, true);
    }

    $arquivo = $_FILES["file"];
    $imgRepetida = 0;

    $file_name = $_POST['idanimal'] . "-" . date('d_m_Y_H_i_s') . "." . explode("/", $_FILES["file"]["type"], 2)[1];
    
    // Validação case aconteça da api enviar mais de uma imagem ao mesmo tempo
    while(file_exists(DIRETORIO_IMAGENS . "/" . $_POST['idanimal'] . "/" . $file_name)){
        $imgRepetida++;
        $file_name = $_POST['idanimal'] . "-" . date('d_m_Y_H_i_s') . "(". $imgRepetida .")" . "." . explode("/", $_FILES["file"]["type"], 2)[1];
    }  

    if(move_uploaded_file($_FILES["file"]["tmp_name"], DIRETORIO_IMAGENS . "/" . $_POST['idanimal'] . "/" . $file_name)){

        $animal = new Animal();

        $idImagem = Imagem::inserir(DIRETORIO_IMAGENS . "/" . $_POST['idanimal'] . "/" . $file_name);

        //Log::inserir($idImagem);

        $data = [
            'idanimal'=>($_POST['idanimal']),
            'idimagem'=>$idImagem
        ];

        $animal->setData($data);

        $animal->salvarGaleria();

        echo json_encode(array(
            "success"=>"true",
            "mensage"=>"Imagem salva com sucesso!"
        ));
    }else{
        echo json_encode(array(
            "success"=>"false",
            "mensage"=>"Falha ao salvar a imagem."
        ));
    }

    exit;
});

$app->get('/animal/galeria/:idanimal', function($idAnimal){

    echo json_encode(Animal::getGaleria($idAnimal));
    exit;

});

$app->get('/animal/:id', function($idAnimal){

    $animal = new Animal();
    $animal->getById($idAnimal);
    echo json_encode($animal->getValues());

    exit;

});

?>