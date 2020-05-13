<?php

$app->get('/', function(){
    $status = array(
        "Status" => "Rodando",
        "Formato" => "API"
    );
    echo json_encode($status);
    exit;
});

$app->post('/', function(){
    $status = array();

    array_push($status, [
        "Status" => "Rodando",
        "Formato" => "API",
        "Method" => "POST"
    ]);

    if(isset($_POST["param"])){
        array_push($status, [
            "Parametro" => $_POST["param"]
        ]);
    }

    echo json_encode($status);
    exit;
});



?>