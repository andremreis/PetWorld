<?php

use \PetWorld\Model\Achado;
use \PetWorld\Model\Log;
use \PetWorld\Model\Imagem;

const DIRETORIO_IMAGENS_ACHADO = "res/app/img/achados";

$app->post('/achado/inserir', function(){

    date_default_timezone_set('America/Sao_Paulo');

    if(!isset($_POST["idusuario"]) ||
    !isset($_POST["descricaolocal"]) ||
    !isset($_POST["descricaoanimal"]) ||
    !isset($_POST["estado"]) ||
    !isset($_POST["cidade"]) ||
    !isset($_POST["acolhido"]) ||
    !isset($_FILES["file"])){
        $faltante = "";

        if(!isset($_POST["idusuario"])) $faltante .= "idusuario\n";
        if(!isset($_POST["descricaolocal"])) $faltante .= "descricaolocal\n";
        if(!isset($_POST["descricaoanimal"])) $faltante .= "descricaoanimal\n";
        if(!isset($_POST["estado"])) $faltante .= "estado\n";
        if(!isset($_POST["cidade"])) $faltante .= "cidade\n";
        if(!isset($_POST["acolhido"])) $faltante .= "acolhido\n";
        if(!isset($_FILES["file"])) $faltante .= "file\n";

        echo json_encode(array(
            "success"=>"false",
            "mensage"=>"POST com falta de informações! - \n" . $faltante
        )); 
        exit;
    }

    //Log::inserir(json_encode($_FILES));

    if(!file_exists(DIRETORIO_IMAGENS_ACHADO)){
        mkdir(DIRETORIO_IMAGENS_ACHADO, 0777, true);
    }

    if(!file_exists(DIRETORIO_IMAGENS_ACHADO . "/" . $_POST['idusuario'])){
        mkdir(DIRETORIO_IMAGENS_ACHADO . "/" . $_POST['idusuario'], 0777, true);
    }

    $arquivo = $_FILES["file"];
    $imgRepetida = 0;

    $file_name = $_POST['idusuario'] . "-" . date('d_m_Y_H_i_s') . "." . explode("/", $arquivo["type"], 2)[1];
    
    // Validação case aconteça da api enviar mais de uma imagem ao mesmo tempo
    while(file_exists(DIRETORIO_IMAGENS_ACHADO . "/" . $_POST['idusuario'] . "/" . $file_name)){
        $imgRepetida++;
        $file_name = $_POST['idusuario'] . "-" . date('d_m_Y_H_i_s') . "(". $imgRepetida .")" . "." . explode("/", $arquivo["type"], 2)[1];
    }  

    if(move_uploaded_file($arquivo["tmp_name"], DIRETORIO_IMAGENS_ACHADO . "/" . $_POST['idusuario'] . "/" . $file_name)){

        $achado = new Achado();

        $idImagem = Imagem::inserir(DIRETORIO_IMAGENS_ACHADO . "/" . $_POST['idusuario'] . "/" . $file_name);

        $data = $_POST;
        $data['idimagem'] = $idImagem;

        $achado->setData($data);

        $achado->save();

        echo json_encode($achado->getValues()); 
        
        exit;
    
    }else{
        echo json_encode(array(
            "success"=>"false",
            "mensage"=>"Falha ao cadastrar."
        ));
    }
});

$app->get('/achado/:idachado', function($idachado){

    $achado = new Achado();
    $achado->getById($idachado);
    echo json_encode($achado->getValues());
    exit;

});

$app->get('/achado', function(){

    $achado = new Achado();
    $achado->listAll();
    echo json_encode($achado->getValues());
    exit;

});

?>